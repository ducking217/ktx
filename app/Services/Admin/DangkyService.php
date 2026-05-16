<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Enums\BedStatus;
use App\Enums\ContractStatus;
use App\Enums\InvoiceStatus;
use App\Enums\RegistrationStatus;
use App\Enums\RegistrationType;
use App\Contracts\Admin\DangkyServiceInterface;
use App\Contracts\Admin\HoanTienServiceInterface;
use App\Contracts\Admin\HopdongServiceInterface;
use App\Mail\DangkyDaDuyetMail;
use App\Mail\DangkyKhachThanhCongMail;
use App\Models\Baohong;
use App\Models\Dangky;
use App\Models\Giuong;
use App\Models\Hoadon;
use App\Models\Hopdong;
use App\Models\LoaiPhong;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\ThanhToan;
use App\Models\ToaNha;
use App\Models\User;
use App\Traits\HoTroNghiepVu;
use App\Traits\PhanHoiService;
use App\Traits\KiemtraKyluat;
use App\Enums\BaohongStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**

 * Khu vực: Admin / Đăng ký cư trú
 
 * Vai trò: Nghiệp vụ duyệt hồ sơ, thu phí, cấp phòng và xử lý trả phòng.

 */

class DangkyService implements DangkyServiceInterface
{
    use HoTroNghiepVu, PhanHoiService, KiemtraKyluat;

    private const MESSAGE_ROOM_FULL = 'Phòng này đã đầy, vui lòng chọn phòng khác.';

    public function __construct(
        private readonly HoanTienServiceInterface $hoanTienService,
        private readonly HopdongServiceInterface $hopdongService
    ) {}

    // ─── SINH VIÊN (đã có tài khoản) ─────────────────────────────────────────

    /**
     * Sinh viên đăng ký phòng (chọn Tòa nhà + Loại phòng).
     */
    public function luuDangKySinhVien(array $data): array
    {
        try {
            $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
            if (!$sinhvien) return $this->traVeLoi('Không tìm thấy thông tin sinh viên.');

            $ketQuaKyluat = $this->kiemTraKyluat($sinhvien->id);
            if ($ketQuaKyluat['bi_chan']) return $this->traVeLoi($ketQuaKyluat['ly_do']);

            $phongId = $data['phong_id'] ?? null;
            if (!$phongId) return $this->traVeLoi('Dữ liệu phòng không hợp lệ.');

            $phong = Phong::find($phongId);
            if (!$phong) return $this->traVeLoi('Phòng không tồn tại.');

            return DB::transaction(function () use ($phong, $sinhvien) {
                // Kiểm tra đã có hợp đồng active chưa
                if (Hopdong::where('sinhvien_id', $sinhvien->id)
                    ->where('trang_thai', ContractStatus::Active->value)
                    ->exists()) {
                    return $this->traVeLoi('Bạn đã được xếp phòng.');
                }

                // Kiểm tra đã gửi đơn pending chưa
                if (Dangky::where('user_id', $sinhvien->user_id)
                    ->where('trang_thai', RegistrationStatus::Pending)
                    ->exists()) {
                    return $this->traVeLoi('Bạn đã gửi đăng ký, vui lòng chờ admin xử lý.');
                }

                Dangky::create([
                    'user_id'       => $sinhvien->user_id,
                    'toa_nha_id'    => $phong->toa_nha_id,
                    'loai_phong_id' => $phong->loai_phong_id,
                    'phong_id'      => $phong->id,
                    'trang_thai'    => RegistrationStatus::Pending,
                    'lookup_token'  => Str::random(32),
                ]);

                return $this->traVeThanhCong('Gửi đăng ký phòng thành công, vui lòng chờ xác nhận.');
            });
        } catch (\Throwable $e) {
            Log::error("Student registration failed: " . $e->getMessage());
            return $this->traVeLoi('Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function xuLyYeuCauTraPhong(int $dangkyId, ?int $phiHuHai = null): array
    {
        try {
            return DB::transaction(function () use ($dangkyId, $phiHuHai) {
                $dangky = Dangky::lockForUpdate()->find($dangkyId);
                if (! $dangky) return $this->traVeLoi('Không tìm thấy yêu cầu.');

                if ($dangky->trang_thai !== RegistrationStatus::Pending) {
                    return $this->traVeLoi('Yêu cầu này đã được xử lý.');
                }

                if (! Str::startsWith((string) $dangky->ghi_chu, 'TRA_PHONG')) {
                    return $this->traVeLoi('Yêu cầu không hợp lệ (không phải trả phòng).');
                }

                $sinhvien = Sinhvien::where('user_id', $dangky->user_id)->lockForUpdate()->first();
                if (! $sinhvien) return $this->traVeLoi('Không tìm thấy sinh viên cho yêu cầu này.');

                $hopdong = Hopdong::where('sinhvien_id', $sinhvien->id)
                    ->where('trang_thai', ContractStatus::Active->value)
                    ->lockForUpdate()
                    ->first();

                if (! $hopdong) {
                    $dangky->transitionTo(RegistrationStatus::Completed->value);
                    return $this->traVeThanhCong('Sinh viên hiện không còn hợp đồng hoạt động. Đã đánh dấu yêu cầu đã xử lý.');
                }

                $soHoaDonChuaThanhToan = Hoadon::where('hopdong_id', $hopdong->id)
                    ->whereIn('trang_thai', [InvoiceStatus::Unpaid->value, InvoiceStatus::Overdue->value])
                    ->where('loai_hoadon', '!=', 'refund')
                    ->count();

                if ($soHoaDonChuaThanhToan > 0) {
                    return $this->traVeLoi('Sinh viên còn hóa đơn chưa thanh toán. Không thể xử lý trả phòng.');
                }

                $phongId = (int) ($hopdong->phong_id ?? 0);
                $coBaoHongSinhVien = Baohong::query()
                    ->where('sinhvien_id', $sinhvien->id)
                    ->where('phong_id', $phongId)
                    ->where('nguoi_chiu_phi', 'sinhvien')
                    ->whereIn('trang_thai', [BaohongStatus::Pending->value, BaohongStatus::Processing->value, BaohongStatus::Done->value])
                    ->exists();

                if ($coBaoHongSinhVien && $phiHuHai === null) {
                    return $this->traVeLoi('Sinh viên có báo hỏng. Vui lòng xác nhận phí hư hại trước khi duyệt trả phòng.');
                }

                $phiHuHaiSuDung = $coBaoHongSinhVien ? max(0, (int) $phiHuHai) : 0;

                $ketQuaThanhLy = $this->hopdongService->thanhLyHopDong($hopdong->id, $phiHuHaiSuDung);
                if (($ketQuaThanhLy['toast_loai'] ?? null) === 'loi') {
                    return $ketQuaThanhLy;
                }

                $dangky->transitionTo(RegistrationStatus::Completed->value);
                return $this->traVeThanhCong('Đã xử lý trả phòng và thanh lý hợp đồng.');
            });
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    public function tuChoiYeuCauTraPhong(int $dangkyId, ?string $reason): array
    {
        try {
            return DB::transaction(function () use ($dangkyId, $reason) {
                $dangky = Dangky::lockForUpdate()->find($dangkyId);
                if (! $dangky) return $this->traVeLoi('Không tìm thấy yêu cầu.');

                if ($dangky->trang_thai !== RegistrationStatus::Pending) {
                    return $this->traVeLoi('Yêu cầu này đã được xử lý.');
                }

                if (! Str::startsWith((string) $dangky->ghi_chu, 'TRA_PHONG')) {
                    return $this->traVeLoi('Yêu cầu không hợp lệ (không phải trả phòng).');
                }

                $note = trim((string) $reason);
                $dangky->update([
                    'trang_thai' => RegistrationStatus::Rejected->value,
                    'ghi_chu' => $note !== '' ? "TRA_PHONG|{$note}" : 'TRA_PHONG|',
                ]);

                return $this->traVeThanhCong('Đã từ chối yêu cầu trả phòng.');
            });
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    /**
     * Sinh viên yêu cầu trả phòng.
     */
    public function yeuCauTraPhong(?string $reason = null): array
    {
        try {
            $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
            if (!$sinhvien) return $this->traVeLoi('Không tìm thấy thông tin sinh viên.');

            $hopdongHienTai = Hopdong::where('sinhvien_id', $sinhvien->id)
                ->where('trang_thai', ContractStatus::Active->value)
                ->first();

            if (!$hopdongHienTai) return $this->traVeLoi('Bạn hiện không có phòng để trả.');

            $soHoaDonChuaThanhToan = Hoadon::where('hopdong_id', $hopdongHienTai->id)
                ->whereIn('trang_thai', [InvoiceStatus::Unpaid->value, InvoiceStatus::Overdue->value])
                ->where('loai_hoadon', '!=', 'refund')
                ->count();

            if ($soHoaDonChuaThanhToan > 0) {
                return $this->traVeLoi('Bạn còn hóa đơn chưa thanh toán. Vui lòng thanh toán trước khi gửi yêu cầu trả phòng.');
            }

            if (Dangky::where('user_id', $sinhvien->user_id)
                ->where('trang_thai', RegistrationStatus::Pending)
                ->whereNotNull('user_id') // phân biệt đơn trả phòng
                ->where('ghi_chu', 'like', 'TRA_PHONG%')
                ->exists()) {
                return $this->traVeLoi('Bạn đã gửi yêu cầu trả phòng, đang chờ xử lý.');
            }

            $note = trim((string) $reason);

            Dangky::create([
                'user_id'      => $sinhvien->user_id,
                'toa_nha_id'   => $hopdongHienTai->giuong->phong->toa_nha_id,
                'loai_phong_id' => $hopdongHienTai->giuong->phong->loai_phong_id,
                'trang_thai'   => RegistrationStatus::Pending,
                'ghi_chu'      => $note !== '' ? "TRA_PHONG|{$note}" : 'TRA_PHONG|',
                'lookup_token' => Str::random(32),
            ]);

            return $this->traVeThanhCong('Gửi yêu cầu trả phòng thành công.');
        } catch (\Throwable $e) {
            Log::error("Leave room request failed: " . $e->getMessage());
            return $this->traVeLoi('Có lỗi xảy ra.');
        }
    }

    // ─── KHÁCH (chưa có tài khoản) ───────────────────────────────────────────

    /**
     * Khách đăng ký từ Landing Page.
     */
    public function luuDangkyKhach(array $data): array
    {
        try {
            return DB::transaction(function () use ($data) {
                $phong = Phong::with(['toanha', 'loaiphong'])->find((int) ($data['phong_id'] ?? 0));
                if (!$phong) {
                    return $this->traVeLoi('Phòng không tồn tại.');
                }

                $toaNha = $phong->toanha;
                $loaiPhong = $phong->loaiphong;
                if (!$toaNha || !$loaiPhong) {
                    return $this->traVeLoi('Thông tin tòa nhà hoặc loại phòng không hợp lệ.');
                }

                $soGiuongTrong = Giuong::where('phong_id', $phong->id)
                    ->where('trang_thai', BedStatus::Available)
                    ->count();

                if ($soGiuongTrong === 0) {
                    return $this->traVeLoi('Hiện không còn giường trống cho loại phòng này.');
                }

                $filePaths   = $this->luuAnhDangKy($data);
                $lookupToken = Str::random(32);

                $dangky = Dangky::create([
                    'ho_ten'        => $data['ho_ten'],
                    'email'         => $data['email'],
                    'dob'           => $data['ngay_sinh'] ?? null,
                    'gender'        => $data['gender'] ?? null,
                    'anh_the_path'  => $filePaths['anh_the'] ?? null,
                    'anh_cccd_path' => $filePaths['anh_cccd'] ?? null,
                    'toa_nha_id'    => $phong->toa_nha_id,
                    'loai_phong_id' => $phong->loai_phong_id,
                    'phong_id'      => $phong->id,
                    'trang_thai'    => RegistrationStatus::Pending,
                    'lookup_token'  => $lookupToken,
                    'phone_encrypted'   => isset($data['so_dien_thoai']) ? encrypt($data['so_dien_thoai']) : null,
                    'id_card_encrypted' => isset($data['so_cccd']) ? encrypt($data['so_cccd']) : null,
                ]);

                $dangky->update([
                    'token_expires_at' => now()->addHours(24),
                ]);

                $emailSent = $this->guiEmailThongBao($data, $toaNha, $loaiPhong, $lookupToken);

                $message = 'Đăng ký thành công. Mã tra cứu: ' . $lookupToken;
                if (!$emailSent) {
                    $message .= ' (Không gửi được email, vui lòng lưu mã để tra cứu).';
                }

                return $this->traVeThanhCong($message);
            });
        } catch (\Throwable $e) {
            Log::error('Guest registration failed', [
                'exception' => $e,
                'phong_id' => $data['phong_id'] ?? null,
                'email_hash' => isset($data['email']) ? sha1((string) $data['email']) : null,
            ]);
            return $this->traVeLoi('Đăng ký thất bại. Vui lòng thử lại hoặc liên hệ Ban quản lý.');
        }
    }

    // ─── ADMIN ACTIONS ────────────────────────────────────────────────────────

    public function lietKeDangKyAdmin(Request $request): array
    {
        $status = $request->query('status', 'Tất cả');
        $type = $request->query('type', 'thue-phong');

        $filteredQuery = Dangky::query()
            ->when($status && $status !== 'Tất cả', fn ($q) => $q->where('trang_thai', $status));

        $countTraPhong = (clone $filteredQuery)->where('ghi_chu', 'like', 'TRA_PHONG%')->count();
        $countThuePhong = (clone $filteredQuery)->where(function ($query) {
            $query->whereNull('ghi_chu')
                ->orWhere('ghi_chu', 'not like', 'TRA_PHONG%');
        })->count();

        $registrationsQuery = (clone $filteredQuery)
            ->select([
                'id',
                'user_id',
                'phong_id',
                'ho_ten',
                'email',
                'phone_encrypted',
                'ghi_chu',
                'trang_thai',
                'token_expires_at',
                'anh_cccd_path',
                'created_at',
            ])
            ->when($type === 'tra-phong', function ($query) {
                return $query->where('ghi_chu', 'like', 'TRA_PHONG%');
            })
            ->when($type !== 'tra-phong', function ($query) {
                return $query->where(function ($sub) {
                    $sub->whereNull('ghi_chu')
                        ->orWhere('ghi_chu', 'not like', 'TRA_PHONG%');
                });
            })
            ->orderByDesc('created_at');

        if ($type === 'tra-phong') {
            $registrationsQuery->with([
                'user:id,name,email,phone',
                'user.sinhvien:id,user_id',
                'user.sinhvien.current_hopdong:id,sinhvien_id,giuong_id,phong_id',
                'user.sinhvien.current_hopdong.giuong:id,phong_id',
                'user.sinhvien.current_hopdong.giuong.phong:id,ten_phong',
            ]);
        } else {
            $registrationsQuery->with([
                'user:id,name,email,phone',
                'phong:id,ten_phong',
            ]);
        }

        $registrations = $registrationsQuery->paginate(15)->withQueryString();

        if ($type === 'tra-phong') {
            $banGhi = $registrations->getCollection();

            $pairs = $banGhi
                ->map(function ($dangky) {
                    $sinhvienId = (int) ($dangky->user?->sinhvien?->id ?? 0);
                    $phongId = (int) ($dangky->user?->sinhvien?->current_hopdong?->phong_id ?? 0);
                    return [
                        'dangky' => $dangky,
                        'sinhvien_id' => $sinhvienId,
                        'phong_id' => $phongId,
                    ];
                })
                ->filter(fn ($row) => $row['sinhvien_id'] > 0 && $row['phong_id'] > 0)
                ->values();

            $sinhvienIds = $pairs->pluck('sinhvien_id')->unique()->values()->all();
            $phongIds = $pairs->pluck('phong_id')->unique()->values()->all();

            $agg = [];
            if (! empty($sinhvienIds) && ! empty($phongIds)) {
                $rows = Baohong::query()
                    ->selectRaw('sinhvien_id, phong_id, COUNT(*) as so_bao_hong, COALESCE(SUM(chi_phi_du_kien), 0) as tong_chi_phi')
                    ->whereIn('sinhvien_id', $sinhvienIds)
                    ->whereIn('phong_id', $phongIds)
                    ->where('nguoi_chiu_phi', 'sinhvien')
                    ->whereIn('trang_thai', [BaohongStatus::Pending->value, BaohongStatus::Processing->value, BaohongStatus::Done->value])
                    ->groupBy('sinhvien_id', 'phong_id')
                    ->get();

                foreach ($rows as $row) {
                    $key = (int) $row->sinhvien_id . ':' . (int) $row->phong_id;
                    $agg[$key] = [
                        'so_bao_hong' => (int) $row->so_bao_hong,
                        'tong_chi_phi' => (int) $row->tong_chi_phi,
                    ];
                }
            }

            foreach ($pairs as $row) {
                $key = (int) $row['sinhvien_id'] . ':' . (int) $row['phong_id'];
                $info = $agg[$key] ?? ['so_bao_hong' => 0, 'tong_chi_phi' => 0];

                $row['dangky']->co_bao_hong = $info['so_bao_hong'] > 0;
                $row['dangky']->so_bao_hong = $info['so_bao_hong'];
                $row['dangky']->phi_hu_hai_goi_y = max(0, $info['tong_chi_phi']);
            }
        }

        return [
            'danhsachdangky' => $registrations,
            'status' => $status,
            'type' => $type,
            'countTraPhong' => $countTraPhong,
            'countThuePhong' => $countThuePhong,
        ];
    }

    /**
     * Admin duyệt hồ sơ → chuyển sang chờ thanh toán.
     */
    public function duyetHoSo(int $id): array
    {
        return DB::transaction(function () use ($id) {
            $dangky = Dangky::lockForUpdate()->find($id);
            if (! $dangky || $dangky->trang_thai !== RegistrationStatus::Pending) {
                return $this->traVeLoi('Đơn không hợp lệ hoặc đã được xử lý.');
            }

            $dangky->transitionTo(RegistrationStatus::ApprovedPendingPayment->value);

            if ($dangky->email) {
                Mail::to($dangky->email)->queue(new \App\Mail\PaymentRequestMail($dangky));
            }

            return $this->traVeThanhCong('Duyệt hồ sơ thành công. Chờ sinh viên thanh toán.');
        });
    }

    /**
     * Admin xác nhận thanh toán → tạo User, Sinhvien, Hopdong, gán Giuong.
     */
    public function xacNhanThanhToan(int $id): array
    {
        return DB::transaction(function () use ($id) {
            $dangky = Dangky::with(['toanha', 'loaiphong'])
                ->where('id', $id)
                ->lockForUpdate()
                ->first();

            if (!$dangky || $dangky->trang_thai !== RegistrationStatus::ApprovedPendingPayment) {
                return $this->traVeLoi('Đơn không ở trạng thái chờ xác nhận thanh toán.');
            }

            // Tìm giường trống phù hợp với nguyện vọng
            $giuong = Giuong::whereHas('phong', fn($q) =>
                $q->where('toa_nha_id', $dangky->toa_nha_id)
                  ->where('loai_phong_id', $dangky->loai_phong_id)
            )->where('trang_thai', BedStatus::Available)
             ->lockForUpdate()
             ->first();

            if (!$giuong) {
                return $this->traVeLoi('Hiện tại không còn giường trống phù hợp với nguyện vọng.');
            }

            // Tạo User (nếu là khách mới)
            $user = $dangky->user_id
                ? User::find($dangky->user_id)
                : $this->taoUserTuDangKy($dangky);

            $sinhvien = Sinhvien::where('user_id', $user->id)->first() ?? $this->taoSinhvienTuDangKy($user, $dangky);
            $this->diChuyenFileDangKySangSinhvien($dangky, $sinhvien);

            // Tạo Hopdong
            $hopdong = Hopdong::create([
                'sinhvien_id'   => $sinhvien->id,
                'phong_id'      => $giuong->phong_id,
                'giuong_id'     => $giuong->id,
                'ngay_bat_dau'  => now()->format('Y-m-d'),
                'ngay_ket_thuc' => now()->addMonths(5)->format('Y-m-d'),
                'gia_thuc_te'   => $dangky->loaiphong->gia_thang ?? 0,
                'trang_thai'    => ContractStatus::Active->value,
            ]);

            // Cập nhật trạng thái giường
            $giuong->update(['trang_thai' => BedStatus::Occupied]);

            // Hoàn tất đăng ký
            $dangky->update([
                'trang_thai' => RegistrationStatus::Completed,
                'phong_id'   => $giuong->phong_id,
            ]);

            // Xác nhận thanh toán giữ chỗ/cọc: tạo hóa đơn cọc và đánh dấu đã thanh toán
            $invoiceService = app(\App\Services\Admin\HoadonService::class);
            $hoadonCoc = $invoiceService->taoHoaDonTheChan($sinhvien);
            $hoadonCoc->transitionTo(InvoiceStatus::Paid->value);

            ThanhToan::create([
                'hoadon_id' => $hoadonCoc->id,
                'nguoi_xac_nhan' => Auth::id(),
                'phuong_thuc' => 'transfer',
                'ma_giao_dich' => null,
                'so_tien' => (int) $hoadonCoc->tong_tien,
                'ngay_giao_dich' => now(),
                'ghi_chu' => 'Xác nhận thanh toán khi cấp phòng (guest).',
            ]);

            $hopdong->update([
                'tien_coc' => (int) $hoadonCoc->tong_tien,
            ]);

            $kyGhiChu = 'Ky ' . now()->month . '/' . now()->year;
            $daCoHoaDonThang = \App\Models\Hoadon::query()
                ->where('hopdong_id', $hopdong->id)
                ->where('loai_hoadon', 'monthly')
                ->where('ghi_chu', $kyGhiChu)
                ->exists();

            if (! $daCoHoaDonThang) {
                $invoiceService->taoHoaDonHangThang($sinhvien, (int) now()->month, (int) now()->year, now()->format('Y-m-d'));
            }

            // Magic link
            $url = \Illuminate\Support\Facades\URL::temporarySignedRoute(
                'magic-link.login',
                now()->addHours(72),
                ['user_id' => $user->id]
            );

            try {
                Mail::to($user->email)->queue(
                    new \App\Mail\LoginMagicLinkMail($user, $url)
                );
            } catch (\Throwable $e) {
                Log::error("Failed to send Magic Link Mail: " . $e->getMessage());
            }

            return $this->traVeThanhCong('Xác nhận thành công. Đã gửi link đăng nhập tới sinh viên.');
        });
    }

    public function tuChoiDangKy(int $id, ?string $reason): array
    {
        try {
            $dangky = Dangky::find($id);
            if (!$dangky) return $this->traVeLoi('Không tìm thấy đăng ký.');

            if (Str::startsWith((string) $dangky->ghi_chu, 'TRA_PHONG')) {
                return $this->tuChoiYeuCauTraPhong($id, $reason);
            }

            if (!$dangky->transitionTo(RegistrationStatus::Rejected->value, $reason)) {
                return $this->traVeLoi('Không thể từ chối ở trạng thái hiện tại.');
            }

            return $this->traVeThanhCong('Từ chối đăng ký thành công.');
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    public function layDuLieuFormDangKyKhach(int $phongId): array
    {
        $phong = Phong::with(['toanha', 'loaiphong'])->find($phongId);

        if (!$phong) {
            return $this->traVeLoi('Phòng không tồn tại.');
        }

        // Đếm số giường trống trong phòng
        $soGiuongTrong = Giuong::where('phong_id', $phongId)
            ->where('trang_thai', BedStatus::Available)
            ->count();

        return [
            'success'        => true,
            'phong'          => $phong,
            'so_giuong_trong' => $soGiuongTrong,
        ];
    }

    public function layDuLieuTraCuuKhach(?string $token): array
    {
        $dangky       = null;
        $errorMessage = null;

        if ($token) {
            $dangky = Dangky::with(['toanha', 'loaiphong', 'phong.toanha', 'phong.loaiphong'])
                ->where('lookup_token', $token)
                ->first();

            if (!$dangky) {
                $errorMessage = 'Mã tra cứu không hợp lệ hoặc đã hết hạn.';
                Log::warning('Guest lookup failed', ['token_partial' => substr((string) $token, 0, 8)]);
            } elseif ($dangky->token_expires_at && $dangky->token_expires_at->isPast()) {
                $errorMessage = 'Mã tra cứu không hợp lệ hoặc đã hết hạn.';
                $dangky = null;
                Log::warning('Guest lookup expired', ['token_partial' => substr((string) $token, 0, 8)]);
            }
        }

        return ['token' => $token, 'dangky' => $dangky, 'error_message' => $errorMessage];
    }

    // ─── Private Helpers ──────────────────────────────────────────────────────

    private function luuAnhDangKy(array $data): array
    {
        $anhThePath  = null;
        $anhCccdPath = null;

        if (isset($data['anh_the']) && $data['anh_the'] instanceof \Illuminate\Http\UploadedFile) {
            $anhThePath = $data['anh_the']->store('dangky/anh-the', 'private');
        }
        if (isset($data['anh_cccd']) && $data['anh_cccd'] instanceof \Illuminate\Http\UploadedFile) {
            $anhCccdPath = $data['anh_cccd']->store('dangky/anh-cccd', 'private');
        }

        return ['anh_the' => $anhThePath, 'anh_cccd' => $anhCccdPath];
    }

    private function guiEmailThongBao(array $data, ToaNha $toaNha, LoaiPhong $loaiPhong, string $lookupToken): bool
    {
        try {
            $lookupUrl = route('guest.lookup', ['token' => $lookupToken]);
            Mail::to($data['email'])->queue(new DangkyKhachThanhCongMail(
                $data['ho_ten'],
                "{$toaNha->ten_toa_nha} — {$loaiPhong->ten_loai}",
                $lookupToken,
                $lookupUrl
            ));
            return true;
        } catch (\Throwable $e) {
            Log::error('Guest registration email failed', [
                'exception' => $e,
                'token_partial' => substr($lookupToken, 0, 8),
                'email_hash' => isset($data['email']) ? sha1((string) $data['email']) : null,
            ]);
            return false;
        }
    }

    private function diChuyenFileDangKySangSinhvien(Dangky $dangky, Sinhvien $sinhvien): void
    {
        $disk = Storage::disk('private');

        $anhThe = is_string($dangky->anh_the_path) ? ltrim($dangky->anh_the_path, '/') : null;
        $anhCccd = is_string($dangky->anh_cccd_path) ? ltrim($dangky->anh_cccd_path, '/') : null;

        if ($anhThe && str_starts_with($anhThe, 'private/')) {
            $anhThe = substr($anhThe, strlen('private/'));
        }
        if ($anhCccd && str_starts_with($anhCccd, 'private/')) {
            $anhCccd = substr($anhCccd, strlen('private/'));
        }

        $updatesSinhvien = [];
        $updatesDangky = [];

        if ($anhThe && $disk->exists($anhThe)) {
            $newPath = "sinhvien/{$sinhvien->id}/anh-the/" . basename($anhThe);
            if ($anhThe !== $newPath) {
                $disk->move($anhThe, $newPath);
            }
            $updatesSinhvien['anh_the_path'] = $newPath;
            $updatesDangky['anh_the_path'] = $newPath;
        }

        if ($anhCccd && $disk->exists($anhCccd)) {
            $newPath = "sinhvien/{$sinhvien->id}/anh-cccd/" . basename($anhCccd);
            if ($anhCccd !== $newPath) {
                $disk->move($anhCccd, $newPath);
            }
            $updatesSinhvien['anh_cccd_path'] = $newPath;
            $updatesDangky['anh_cccd_path'] = $newPath;
        }

        if (!empty($updatesSinhvien)) {
            $sinhvien->fill($updatesSinhvien);
            $sinhvien->save();
        }
        if (!empty($updatesDangky)) {
            $dangky->update($updatesDangky);
        }
    }

    private function taoUserTuDangKy(Dangky $dangky): User
    {
        return User::create([
            'name'      => $dangky->ho_ten,
            'email'     => $dangky->email,
            'password'  => bcrypt(Str::random(12)),
            'vaitro'    => 'sinhvien',
            'is_active' => true,
        ]);
    }

    private function taoSinhvienTuDangKy(User $user, Dangky $dangky): Sinhvien
    {
        return Sinhvien::create([
            'user_id'     => $user->id,
            'ma_sinh_vien' => 'SV' . str_pad((string) $user->id, 5, '0', STR_PAD_LEFT),
            'lop'         => null,
            'khoa'        => null,
        ]);
    }

    /**
     * Admin duyệt đăng ký - Tạo hợp đồng tự động.
     */
    public function duyetDangKy(int $id, ?string $ngayHetHan = null): array
    {
        try {
            return DB::transaction(function () use ($id, $ngayHetHan) {
                $dangky = Dangky::with(['user', 'toanha', 'loaiphong'])
                    ->where('id', $id)
                    ->lockForUpdate()
                    ->first();

                if (!$dangky) {
                    return $this->traVeLoi('Không tìm thấy đăng ký.');
                }

                if ($dangky->trang_thai !== RegistrationStatus::Pending) {
                    return $this->traVeLoi('Đăng ký không ở trạng thái chờ duyệt.');
                }

                // Kiểm tra đã có hợp đồng active chưa
                if ($dangky->user_id) {
                    $hopdongHienTai = Hopdong::where('sinhvien_id', function($query) use ($dangky) {
                        $query->select('id')->from('sinhvien')->where('user_id', $dangky->user_id);
                    })->where('trang_thai', ContractStatus::Active->value)->exists();
                    
                    if ($hopdongHienTai) {
                        return $this->traVeLoi('Sinh viên đã có hợp đồng đang hoạt động.');
                    }
                }

                // Tìm giường trống phù hợp
                $giuong = Giuong::whereHas('phong', fn($q) =>
                    $q->where('toa_nha_id', $dangky->toa_nha_id)
                      ->where('loai_phong_id', $dangky->loai_phong_id)
                )->where('trang_thai', BedStatus::Available)
                 ->lockForUpdate()
                 ->first();

                if (!$giuong) {
                    return $this->traVeLoi('Hiện không còn giường trống cho loại phòng này.');
                }

                // Nếu là sinh viên đã có tài khoản
                if ($dangky->user_id) {
                    $sinhvien = Sinhvien::where('user_id', $dangky->user_id)->first();
                    if (!$sinhvien) {
                        return $this->traVeLoi('Không tìm thấy thông tin sinh viên.');
                    }

                    // Chấm dứt hợp đồng cũ nếu có
                    $this->chamDutHopDongHienTai($sinhvien->id);

                    // Tạo hợp đồng mới
                    $ngayBatDau = now()->format('Y-m-d');
                    $ngayKetThuc = $ngayHetHan ?: now()->addMonths(5)->format('Y-m-d');

                    $hopdong = Hopdong::create([
                        'sinhvien_id'   => $sinhvien->id,
                        'phong_id'      => $giuong->phong_id,
                        'giuong_id'     => $giuong->id,
                        'ngay_bat_dau'  => $ngayBatDau,
                        'ngay_ket_thuc' => $ngayKetThuc,
                        'gia_thuc_te'   => $dangky->loaiphong->gia_thang ?? 0,
                        'trang_thai'    => ContractStatus::Active->value,
                    ]);

                    // Cập nhật trạng thái giường
                    $giuong->update(['trang_thai' => BedStatus::Occupied->value]);

                    // Cập nhật trạng thái đăng ký
                    $dangky->update([
                        'trang_thai' => RegistrationStatus::Approved,
                        'phong_id'   => $giuong->phong_id,
                    ]);

                    // Tạo hóa đơn và gửi thông báo thanh toán
                    $invoiceService = app(\App\Services\Admin\HoadonService::class);
                    $invoiceService->taoHoaDonTheChan($sinhvien);
                    $invoiceService->taoHoaDonHangThang($sinhvien, (int)now()->month, (int)now()->year, now()->format('Y-m-d'));

                    // Gửi email thông báo
                    if ($dangky->user->email) {
                        Mail::to($dangky->user->email)->queue(new DangkyDaDuyetMail(
                            $dangky->user->name,
                            $giuong->phong->ten_phong,
                            $giuong->ma_giuong,
                            $ngayBatDau,
                            $ngayKetThuc
                        ));
                    }

                    return $this->traVeThanhCong('Duyệt đăng ký thành công. Đã tạo hợp đồng và gán phòng.');
                } else {
                    // Đối với khách chưa có tài khoản, chuyển sang chờ thanh toán
                    $dangky->transitionTo(RegistrationStatus::ApprovedPendingPayment->value);
                    
                    if ($dangky->email) {
                        Mail::to($dangky->email)->queue(new \App\Mail\PaymentRequestMail($dangky));
                    }
                    
                    return $this->traVeThanhCong('Duyệt hồ sơ thành công. Đã gửi thông báo thanh toán.');
                }
            });
        } catch (\Throwable $e) {
            Log::error("DuyetDangKy failed: " . $e->getMessage());
            return $this->traVeLoi('Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    private function chamDutHopDongHienTai(int $sinhvienId): void
    {
        $hopdong = Hopdong::where('sinhvien_id', $sinhvienId)
            ->where('trang_thai', ContractStatus::Active->value)
            ->with('giuong')
            ->first();

        if (!$hopdong) return;

        $hopdong->transitionTo(ContractStatus::Terminated->value);

        if ($hopdong->giuong) {
            $hopdong->giuong->update(['trang_thai' => BedStatus::Available->value]);
        }
    }
}
