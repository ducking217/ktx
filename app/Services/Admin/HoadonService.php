<?php

namespace App\Services\Admin;

use App\Contracts\Admin\HoadonServiceInterface;
use App\Enums\BedStatus;
use App\Enums\ContractStatus;
use App\Enums\InvoiceStatus;
use App\Models\ChiSoDienNuoc;
use App\Models\Cauhinh;
use App\Models\Giuong;
use App\Models\Hoadon;
use App\Models\Hopdong;
use App\Models\Lienhe;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\ThanhToan;
use App\Models\Thongbao;
use App\Notifications\HoadonMoiNotification;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**

 * Khu vực: Admin / Hóa đơn
 
 * Vai trò: Xử lý lập hóa đơn, ghi chỉ số, đối soát thanh toán và các thao tác tài chính liên quan.

 */

class HoadonService implements HoadonServiceInterface
{
    use PhanHoiService;

    private const DEFAULT_ELECTRICITY_RATE = 3500;
    private const DEFAULT_WATER_RATE       = 15000;
    private const LOAI_MONTHLY = 'monthly';
    private const LOAI_DEPOSIT = 'deposit';
    private const LOAI_REFUND  = 'refund';
    private const LOAI_EXTRA   = 'extra';

    public function layBangGia(): array
    {
        return [
            'dongiadien' => (int) $this->layGiaTuCauhinh('gia_dien', (string) self::DEFAULT_ELECTRICITY_RATE),
            'dongianuoc' => (int) $this->layGiaTuCauhinh('gia_nuoc', (string) self::DEFAULT_WATER_RATE),
            'phidichvu'  => (int) $this->layGiaTuCauhinh('phi_dich_vu', '50000'),
        ];
    }

    public function lietKeHoaDonAdmin(Request $request): array
    {
        $bangGia = $this->layBangGia();

        $tabFromRequest = (string) $request->query('tab', '');
        $allowedTabs = ['cho-xac-nhan', 'cong-no', 'lich-su', 'hoan-coc'];

        $baseQuery = Hoadon::query()
            ->when($request->phong_id, fn ($q) => $q->where('phong_id', $request->phong_id));

        $baseNonRefundQuery = (clone $baseQuery)->where(function ($q) {
            $q->whereNull('loai_hoadon')
                ->orWhere('loai_hoadon', '!=', self::LOAI_REFUND);
        });

        $tabCounts = [
            'cho_xac_nhan' => (clone $baseNonRefundQuery)->where('trang_thai', InvoiceStatus::PendingConfirmation)->count(),
            'cong_no' => (clone $baseNonRefundQuery)->whereIn('trang_thai', [InvoiceStatus::Unpaid, InvoiceStatus::Overdue])->count(),
            'lich_su' => (clone $baseNonRefundQuery)->where('trang_thai', InvoiceStatus::Paid)->count(),
            'hoan_coc' => (clone $baseQuery)->where('loai_hoadon', self::LOAI_REFUND)->whereIn('trang_thai', [InvoiceStatus::Unpaid, InvoiceStatus::Overdue])->count(),
        ];

        $activeTab = in_array($tabFromRequest, $allowedTabs, true) ? $tabFromRequest : null;
        if (! $activeTab) {
            $activeTab = $tabCounts['cho_xac_nhan'] > 0
                ? 'cho-xac-nhan'
                : ($tabCounts['cong_no'] > 0 ? 'cong-no' : 'lich-su');
        }

        $listQuery = Hoadon::with(['hopdong.sinhvien.user', 'hopdong.giuong.phong', 'phong', 'giao_dich_gan_nhat'])
            ->when($request->phong_id, fn ($q) => $q->where('phong_id', $request->phong_id));

        if ($tabFromRequest === '' && $request->trang_thai) {
            $listQuery = $listQuery->when($request->trang_thai, fn ($q) => $q->where('trang_thai', $request->trang_thai));
        } else {
            $listQuery = match ($activeTab) {
                'cho-xac-nhan' => $listQuery
                    ->where(function ($q) {
                        $q->whereNull('loai_hoadon')
                            ->orWhere('loai_hoadon', '!=', self::LOAI_REFUND);
                    })
                    ->where('trang_thai', InvoiceStatus::PendingConfirmation),
                'lich-su' => $listQuery
                    ->where(function ($q) {
                        $q->whereNull('loai_hoadon')
                            ->orWhere('loai_hoadon', '!=', self::LOAI_REFUND);
                    })
                    ->where('trang_thai', InvoiceStatus::Paid),
                'hoan-coc' => $listQuery->where('loai_hoadon', self::LOAI_REFUND)->whereIn('trang_thai', [InvoiceStatus::Unpaid, InvoiceStatus::Overdue]),
                default => $listQuery
                    ->where(function ($q) {
                        $q->whereNull('loai_hoadon')
                            ->orWhere('loai_hoadon', '!=', self::LOAI_REFUND);
                    })
                    ->whereIn('trang_thai', [InvoiceStatus::Unpaid, InvoiceStatus::Overdue]),
            };
        }

        return [
            'danhsachhoadon' => $listQuery
                ->orderByDesc('created_at')
                ->paginate(20)
                ->withQueryString(),
            'danhsachphong' => Cache::remember('admin.hoadon:rooms-for-meter:v1', now()->addMinutes(5), function () {
                return Phong::query()
                    ->select(['id', 'ten_phong'])
                    ->whereHas('giuongs', fn ($q) => $q->where('trang_thai', BedStatus::Occupied))
                    ->orderBy('ten_phong')
                    ->get();
            }),
            'thongke' => [
                'tong_no'       => (int) (clone $baseNonRefundQuery)->whereIn('trang_thai', [InvoiceStatus::Unpaid, InvoiceStatus::PendingConfirmation, InvoiceStatus::Overdue])->sum('tong_tien'),
                'so_qua_han'    => (int) (clone $baseNonRefundQuery)->where('trang_thai', InvoiceStatus::Overdue)->count(),
                'so_cho_thu'    => (int) (clone $baseNonRefundQuery)->whereIn('trang_thai', [InvoiceStatus::Unpaid, InvoiceStatus::PendingConfirmation])->count(),
                'da_thu_thang'  => (int) (clone $baseNonRefundQuery)->where('trang_thai', InvoiceStatus::Paid)
                    ->whereMonth('ngay_thanh_toan', now()->month)
                    ->whereYear('ngay_thanh_toan', now()->year)
                    ->sum('tong_tien'),
            ],
            'tabs' => $tabCounts,
            'activeTab' => $activeTab,
            ...$bangGia,
        ];
    }

    public function layHoaDonSinhVien(): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
        if (! $sinhvien) {
            return ['error' => 'Không tìm thấy thông tin sinh viên.'];
        }

        $hopdongIds = $sinhvien->hopdongs()->pluck('id');

        $baseQuery = Hoadon::whereIn('hopdong_id', $hopdongIds);

        $tabFromRequest = (string) request()->query('tab', '');
        $allowedTabs = ['can-thanh-toan', 'cho-xac-nhan', 'lich-su'];

        $tabCounts = [
            'can_thanh_toan' => (clone $baseQuery)->whereIn('trang_thai', [InvoiceStatus::Unpaid, InvoiceStatus::Overdue])->count(),
            'cho_xac_nhan' => (clone $baseQuery)->where('trang_thai', InvoiceStatus::PendingConfirmation)->count(),
            'lich_su' => (clone $baseQuery)->where('trang_thai', InvoiceStatus::Paid)->count(),
        ];

        $activeTab = in_array($tabFromRequest, $allowedTabs, true) ? $tabFromRequest : null;
        if (! $activeTab) {
            $activeTab = $tabCounts['can_thanh_toan'] > 0
                ? 'can-thanh-toan'
                : ($tabCounts['cho_xac_nhan'] > 0 ? 'cho-xac-nhan' : 'lich-su');
        }

        $lichSuQuery = match ($activeTab) {
            'cho-xac-nhan' => (clone $baseQuery)->where('trang_thai', InvoiceStatus::PendingConfirmation),
            'lich-su' => (clone $baseQuery)->where('trang_thai', InvoiceStatus::Paid),
            default => (clone $baseQuery)->whereIn('trang_thai', [InvoiceStatus::Unpaid, InvoiceStatus::Overdue]),
        };

        $lichSu = $lichSuQuery
            ->with('giao_dich_tu_choi_gan_nhat')
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return [
            'hoadon'  => $lichSu,
            'thongKe' => [
                'tong_hoa_don'     => (int) (clone $baseQuery)->count(),
                'da_thanh_toan'    => (int) $tabCounts['lich_su'],
                'chua_thanh_toan'  => (int) $tabCounts['can_thanh_toan'],
                'cho_xac_nhan'     => (int) $tabCounts['cho_xac_nhan'],
                'tong_tien_da_tra' => (int) (clone $baseQuery)->where('trang_thai', InvoiceStatus::Paid)->sum('tong_tien'),
            ],
            'tabs' => $tabCounts,
            'activeTab' => $activeTab,
            'thongTinThanhToan' => $this->layThongTinThanhToanMacDinh(),
        ];
    }

    public function layChiTietHoaDonSinhVien(int $id): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
        if (! $sinhvien) {
            return ['error' => 'Không tìm thấy thông tin sinh viên.'];
        }

        $hopdongIds = $sinhvien->hopdongs()->pluck('id');

        $hoadon = Hoadon::where('id', $id)
            ->whereIn('hopdong_id', $hopdongIds)
            ->with(['hopdong.giuong.phong', 'giao_dich_tu_choi_gan_nhat'])
            ->first();

        if (! $hoadon) {
            return ['error' => 'Không tìm thấy hóa đơn.'];
        }

        $soNguoi = Giuong::where('phong_id', $hoadon->hopdong?->giuong?->phong_id)
            ->where('trang_thai', BedStatus::Occupied)
            ->count();

        $thang = null;
        $nam = null;
        if (is_string($hoadon->ghi_chu) && preg_match('/Ky\s+(\d{1,2})\/(\d{4})/u', $hoadon->ghi_chu, $m)) {
            $thang = (int) $m[1];
            $nam = (int) $m[2];
        }
        $thang = $thang ?: (int) ($hoadon->created_at?->format('n') ?? now()->format('n'));
        $nam = $nam ?: (int) ($hoadon->created_at?->format('Y') ?? now()->format('Y'));

        $phongId = (int) ($hoadon->phong_id ?? $hoadon->hopdong?->giuong?->phong_id ?? 0);
        $chiSoDien = ChiSoDienNuoc::where('phong_id', $phongId)
            ->where('loai', 'dien')
            ->where('thang', $thang)
            ->where('nam', $nam)
            ->first();
        $chiSoNuoc = ChiSoDienNuoc::where('phong_id', $phongId)
            ->where('loai', 'nuoc')
            ->where('thang', $thang)
            ->where('nam', $nam)
            ->first();

        $thongBaoNhacNo = Thongbao::query()
            ->where('loai_thong_bao', 'finance')
            ->where('noi_dung', 'like', '%hóa đơn #' . $hoadon->id . '%')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        return [
            'hoadon'            => $hoadon,
            'soNguoiTrongPhong' => max(1, $soNguoi),
            'ky' => [
                'thang' => $thang,
                'nam' => $nam,
            ],
            'thongBaoNhacNo' => $thongBaoNhacNo,
            'chiSoTieuThu' => [
                'dien' => $chiSoDien ? [
                    'chi_so_cu' => (int) $chiSoDien->chi_so_cu,
                    'chi_so_moi' => (int) $chiSoDien->chi_so_moi,
                    'tieu_thu' => max(0, (int) $chiSoDien->chi_so_moi - (int) $chiSoDien->chi_so_cu),
                    'don_vi' => 'kWh',
                ] : null,
                'nuoc' => $chiSoNuoc ? [
                    'chi_so_cu' => (int) $chiSoNuoc->chi_so_cu,
                    'chi_so_moi' => (int) $chiSoNuoc->chi_so_moi,
                    'tieu_thu' => max(0, (int) $chiSoNuoc->chi_so_moi - (int) $chiSoNuoc->chi_so_cu),
                    'don_vi' => 'm³',
                ] : null,
            ],
            'chiTietTien'       => [
                'tien_phong'  => (int) $hoadon->tien_phong,
                'tien_dien'   => (int) $hoadon->tien_dien,
                'tien_nuoc'   => (int) $hoadon->tien_nuoc,
                'phi_dich_vu' => (int) $hoadon->phi_dich_vu,
                'tong_tien'   => $hoadon->tong_tien,
            ],
            'thanhToan' => $this->layThongTinThanhToanChoHoaDon($sinhvien, $hoadon),
        ];
    }

    public function yeuCauXacNhanThanhToanSinhVien(int $id, array $data): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->with('user')->first();
        if (! $sinhvien || ! $sinhvien->user) {
            return $this->traVeLoi('Không tìm thấy thông tin sinh viên.');
        }

        $hopdongIds = $sinhvien->hopdongs()->pluck('id');

        $hoadon = Hoadon::where('id', $id)
            ->whereIn('hopdong_id', $hopdongIds)
            ->first();

        if (! $hoadon) {
            return $this->traVeLoi('Không tìm thấy hóa đơn.');
        }

        if ($hoadon->trang_thai === InvoiceStatus::PendingConfirmation) {
            return $this->traVeLoi('Hóa đơn đang chờ Admin xác nhận.');
        }

        if (in_array($hoadon->trang_thai, [InvoiceStatus::Paid, InvoiceStatus::Cancelled], true)) {
            return $this->traVeLoi('Hóa đơn này không thể gửi yêu cầu xác nhận.');
        }

        $maGiaoDich = trim((string) ($data['ma_giao_dich'] ?? ''));
        $ghiChu = trim((string) ($data['ghi_chu'] ?? ''));

        try {
            DB::transaction(function () use ($sinhvien, $hoadon, $maGiaoDich, $ghiChu) {
                ThanhToan::create([
                    'hoadon_id' => $hoadon->id,
                    'nguoi_xac_nhan' => null,
                    'phuong_thuc' => 'transfer',
                    'ma_giao_dich' => $maGiaoDich !== '' ? $maGiaoDich : null,
                    'so_tien' => (int) $hoadon->tong_tien,
                    'ngay_giao_dich' => now(),
                    'ghi_chu' => $ghiChu !== '' ? $ghiChu : null,
                ]);

                if (! $hoadon->transitionTo(InvoiceStatus::PendingConfirmation->value)) {
                    throw new \Exception('Không thể cập nhật trạng thái hóa đơn.');
                }

                $noiDung = 'Yêu cầu xác nhận thanh toán hóa đơn ' . $hoadon->ma_hoa_don
                    . ' (Số tiền: ' . number_format((int) $hoadon->tong_tien, 0, ',', '.') . 'đ).';
                if ($maGiaoDich !== '') {
                    $noiDung .= ' Mã giao dịch: ' . $maGiaoDich . '.';
                }
                if ($ghiChu !== '') {
                    $noiDung .= ' Ghi chú: ' . $ghiChu . '.';
                }

                Lienhe::create([
                    'ho_ten' => $sinhvien->user->name,
                    'email' => $sinhvien->user->email,
                    'noi_dung' => $noiDung,
                    'trang_thai' => 'Chờ xử lý',
                ]);
            });
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }

        return $this->traVeThanhCong('Đã ghi nhận thanh toán. Hóa đơn đang chờ Admin xác nhận.');
    }

    public function xacNhanThanhToan(int $id): array
    {
        $hoadon = Hoadon::find($id);
        if (! $hoadon) {
            return $this->traVeLoi('Không tìm thấy hóa đơn.');
        }

        try {
            DB::transaction(function () use ($hoadon) {
                $thanhToan = ThanhToan::where('hoadon_id', $hoadon->id)
                    ->whereNull('nguoi_xac_nhan')
                    ->orderByDesc('ngay_giao_dich')
                    ->first();

                if ($thanhToan) {
                    $thanhToan->update(['nguoi_xac_nhan' => Auth::id()]);
                } else {
                    ThanhToan::create([
                        'hoadon_id' => $hoadon->id,
                        'nguoi_xac_nhan' => Auth::id(),
                        'phuong_thuc' => 'cash',
                        'ma_giao_dich' => null,
                        'so_tien' => (int) $hoadon->tong_tien,
                        'ngay_giao_dich' => now(),
                        'ghi_chu' => null,
                    ]);
                }

                if (! $hoadon->transitionTo(InvoiceStatus::Paid->value)) {
                    throw new \Exception('Không thể xác nhận.');
                }
            });
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }

        return $this->traVeThanhCong('Đã xác nhận thanh toán.');
    }

    public function tuChoiXacNhanThanhToan(int $id, ?string $lyDo = null): array
    {
        try {
            DB::transaction(function () use ($id, $lyDo) {
                $hoadon = Hoadon::lockForUpdate()->find($id);
                if (! $hoadon) {
                    throw new \Exception('Không tìm thấy hóa đơn.');
                }

                if ($hoadon->trang_thai !== InvoiceStatus::PendingConfirmation) {
                    throw new \Exception('Hóa đơn này không ở trạng thái chờ xác nhận.');
                }

                $thanhToan = ThanhToan::where('hoadon_id', $hoadon->id)
                    ->whereNull('nguoi_xac_nhan')
                    ->orderByDesc('ngay_giao_dich')
                    ->lockForUpdate()
                    ->first();

                if ($thanhToan) {
                    $ghiChu = trim((string) ($thanhToan->ghi_chu ?? ''));
                    $lyDoGon = trim((string) ($lyDo ?? ''));
                    $ghiChuMoi = $ghiChu;
                    if ($lyDoGon !== '') {
                        $ghiChuMoi = trim($ghiChuMoi !== '' ? ($ghiChuMoi . ' | Từ chối: ' . $lyDoGon) : ('Từ chối: ' . $lyDoGon));
                    }

                    $thanhToan->update([
                        'nguoi_xac_nhan' => Auth::id(),
                        'ghi_chu' => $ghiChuMoi !== '' ? $ghiChuMoi : $thanhToan->ghi_chu,
                    ]);
                }

                $trangThaiMoi = ($hoadon->ngay_het_han && $hoadon->ngay_het_han->isPast())
                    ? InvoiceStatus::Overdue
                    : InvoiceStatus::Unpaid;

                if (! $hoadon->transitionTo($trangThaiMoi->value)) {
                    throw new \Exception('Không thể cập nhật trạng thái hóa đơn.');
                }
            });
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }

        return $this->traVeThanhCong('Đã từ chối xác nhận thanh toán. Hóa đơn đã được đưa về trạng thái cần thanh toán.');
    }

    /**
     * Tạo hóa đơn điện nước hàng tháng cho một phòng.
     */
    public function xuLyHoaDon(array $data): array
    {
        try {
            return DB::transaction(function () use ($data) {
                $phong = Phong::with('loaiphong')->lockForUpdate()->find((int) $data['phong_id']);
                if (! $phong) {
                    throw new \Exception('Không tìm thấy phòng.');
                }

                $thang = (int) $data['thang'];
                $nam = (int) $data['nam'];
                $chiSoDienCu = (int) $data['chisodiencu'];
                $chiSoDienMoi = (int) $data['chisodienmoi'];
                $chiSoNuocCu = (int) $data['chisonuoccu'];
                $chiSoNuocMoi = (int) $data['chisonuocmoi'];

                if ($chiSoDienMoi < $chiSoDienCu || $chiSoNuocMoi < $chiSoNuocCu) {
                    throw new \Exception('Chỉ số mới phải lớn hơn hoặc bằng chỉ số cũ.');
                }

                $hopDongs = Hopdong::where('phong_id', $phong->id)
                    ->where('trang_thai', ContractStatus::Active->value)
                    ->lockForUpdate()
                    ->get();

                if ($hopDongs->isEmpty()) {
                    throw new \Exception('Không có hợp đồng hiệu lực trong phòng để tạo hóa đơn.');
                }

                // Kiểm tra xem đã có hóa đơn đã thanh toán cho kỳ này chưa
                $daThanhToan = Hoadon::where('phong_id', $phong->id)
                    ->where('loai_hoadon', self::LOAI_MONTHLY)
                    ->where('trang_thai', InvoiceStatus::Paid)
                    ->where('ghi_chu', 'like', "Ky {$thang}/{$nam}%")
                    ->exists();

                if ($daThanhToan) {
                    throw new \Exception('Phòng này đã có hóa đơn đã được thanh toán trong kỳ này. Không thể tạo lại.');
                }

                // Xóa các hóa đơn chưa thanh toán cũ của kỳ này để ghi đè
                Hoadon::where('phong_id', $phong->id)
                    ->where('loai_hoadon', self::LOAI_MONTHLY)
                    ->where('trang_thai', InvoiceStatus::Unpaid)
                    ->where('ghi_chu', 'like', "Ky {$thang}/{$nam}%")
                    ->delete();

                $bangGia = $this->layBangGia();
                $tienDienTong = ($chiSoDienMoi - $chiSoDienCu) * $bangGia['dongiadien'];
                $tienNuocTong = ($chiSoNuocMoi - $chiSoNuocCu) * $bangGia['dongianuoc'];
                $phiDichVuTong = (int) $bangGia['phidichvu'];
                $soHopDong = $hopDongs->count();
                $tienDienMoiNguoi = (int) round($tienDienTong / $soHopDong);
                $tienNuocMoiNguoi = (int) round($tienNuocTong / $soHopDong);
                $phiDichVuMoiNguoi = (int) round($phiDichVuTong / $soHopDong);
                $soDaTao = 0;

                ChiSoDienNuoc::updateOrCreate(
                    ['phong_id' => $phong->id, 'loai' => 'dien', 'thang' => $thang, 'nam' => $nam],
                    ['chi_so_cu' => $chiSoDienCu, 'chi_so_moi' => $chiSoDienMoi]
                );

                ChiSoDienNuoc::updateOrCreate(
                    ['phong_id' => $phong->id, 'loai' => 'nuoc', 'thang' => $thang, 'nam' => $nam],
                    ['chi_so_cu' => $chiSoNuocCu, 'chi_so_moi' => $chiSoNuocMoi]
                );

                foreach ($hopDongs as $hopdong) {
                    $components = $this->buildAmounts(
                        (int) $hopdong->gia_thuc_te,
                        $tienDienMoiNguoi,
                        $tienNuocMoiNguoi,
                        $phiDichVuMoiNguoi
                    );

                    $hoaDon = Hoadon::create([
                        'hopdong_id' => $hopdong->id,
                        'phong_id' => $phong->id,
                        'ma_hoa_don' => $this->generateInvoiceCode('HD'),
                        'loai_hoadon' => self::LOAI_MONTHLY,
                        'tien_phong' => $components['tien_phong'],
                        'tien_dien' => $components['tien_dien'],
                        'tien_nuoc' => $components['tien_nuoc'],
                        'phi_dich_vu' => $components['phi_dich_vu'],
                        'tong_tien' => $components['tong_tien'],
                        'trang_thai' => InvoiceStatus::Unpaid,
                        'ngay_het_han' => now()->endOfMonth()->toDateString(),
                        'ghi_chu' => "Ky {$thang}/{$nam}",
                    ]);

                    $soDaTao++;
                    $this->thongBaoPhong($phong->id, $hoaDon);
                }

                return $this->traVeThanhCong("Đã tạo {$soDaTao} hóa đơn cho phòng {$phong->ten_phong}.");
            });
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    public function taoHoaDonTheChan(Sinhvien $sinhvien): Hoadon
    {
        $hopdong = $sinhvien->current_hopdong;
        $amount  = max(1000000, (int) $this->layGiaTuCauhinh('phi_the_chan', '1000000'));
        $components = $this->buildAmounts(0, 0, 0, $amount);

        return Hoadon::create([
            'hopdong_id' => $hopdong?->id,
            'phong_id' => $hopdong?->phong_id,
            'ma_hoa_don' => $this->generateInvoiceCode('DEPOSIT'),
            'loai_hoadon' => self::LOAI_DEPOSIT,
            'tien_phong' => $components['tien_phong'],
            'tien_dien' => $components['tien_dien'],
            'tien_nuoc' => $components['tien_nuoc'],
            'phi_dich_vu' => $components['phi_dich_vu'],
            'tong_tien' => $components['tong_tien'],
            'trang_thai' => InvoiceStatus::Unpaid,
            'ngay_het_han' => now()->addDays(7)->toDateString(),
            'ghi_chu' => 'Phi the chan',
        ]);
    }

    public function taoHoaDonHangThang(Sinhvien $sinhvien, int $month, int $year, ?string $startDate = null): Hoadon
    {
        $hopdong = $sinhvien->current_hopdong;
        $basePrice  = (int) ($hopdong?->gia_thuc_te ?? 0);
        $finalPrice = $startDate ? $this->tinhTienPhongTheoNgay($basePrice, $startDate) : $basePrice;
        $phiDichVu  = (int) $this->layGiaTuCauhinh('phi_dich_vu', '50000');
        $components = $this->buildAmounts($finalPrice, 0, 0, $phiDichVu);

        return Hoadon::create([
            'hopdong_id' => $hopdong?->id,
            'phong_id' => $hopdong?->phong_id,
            'ma_hoa_don' => "MO-{$month}-{$year}-" . strtoupper(Str::random(6)),
            'loai_hoadon' => self::LOAI_MONTHLY,
            'tien_phong' => $components['tien_phong'],
            'tien_dien' => $components['tien_dien'],
            'tien_nuoc' => $components['tien_nuoc'],
            'phi_dich_vu' => $components['phi_dich_vu'],
            'tong_tien' => $components['tong_tien'],
            'trang_thai' => InvoiceStatus::Unpaid,
            'ngay_het_han' => now()->endOfMonth()->toDateString(),
            'ghi_chu' => "Ky {$month}/{$year}",
        ]);
    }

    public function taoHoaDonPhat(Sinhvien $sinhvien, int $amount, string $reason): Hoadon
    {
        $hopdong = $sinhvien->current_hopdong;
        $components = $this->buildAmounts(0, 0, 0, $amount);

        return Hoadon::create([
            'hopdong_id' => $hopdong?->id,
            'phong_id' => $hopdong?->phong_id,
            'ma_hoa_don' => $this->generateInvoiceCode('EXTRA'),
            'loai_hoadon' => self::LOAI_EXTRA,
            'tien_phong' => $components['tien_phong'],
            'tien_dien' => $components['tien_dien'],
            'tien_nuoc' => $components['tien_nuoc'],
            'phi_dich_vu' => $components['phi_dich_vu'],
            'tong_tien' => $components['tong_tien'],
            'trang_thai' => InvoiceStatus::Unpaid,
            'ngay_het_han' => now()->addDays(14)->toDateString(),
            'ghi_chu' => $reason,
        ]);
    }

    public function tinhTienPhongTheoNgay(int $baseRoomFee, string $startDate): int
    {
        $start         = \Illuminate\Support\Carbon::parse($startDate);
        $daysInMonth   = $start->daysInMonth;
        $remainingDays = $daysInMonth - $start->day + 1;
        return (int) round(($baseRoomFee / $daysInMonth) * $remainingDays);
    }

    public function xacNhanViPham(int $id): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->first();

        if (! $sinhvien) {
            return $this->traVeLoi('Không tìm thấy thông tin sinh viên.');
        }

        $hopdongIds = $sinhvien->hopdongs()->pluck('id');

        $hoadon = Hoadon::where('id', $id)
            ->whereIn('hopdong_id', $hopdongIds)
            ->first();

        if (! $hoadon) {
            return $this->traVeLoi('Không tìm thấy hóa đơn.');
        }

        if (! $hoadon->transitionTo(InvoiceStatus::Unpaid->value)) {
            return $this->traVeLoi('Không thể xác nhận.');
        }

        return $this->traVeThanhCong('Đã xác nhận lỗi. Hãy thanh toán hóa đơn này.');
    }

    public function xuLyHoaDonHangLoat(array $data): array
    {
        $count = 0;
        $items = $data['hoa_don'] ?? $data['items'] ?? [];

        return DB::transaction(function () use ($items, $data, &$count) {
            foreach ($items as $item) {
                if (! isset($item['phong_id'])) {
                    continue;
                }

                $result = $this->xuLyHoaDon([
                    'phong_id' => $item['phong_id'],
                    'thang' => $data['thang'],
                    'nam' => $data['nam'],
                    'chisodiencu' => $item['chisodiencu'],
                    'chisodienmoi' => $item['chisodienmoi'],
                    'chisonuoccu' => $item['chisonuoccu'],
                    'chisonuocmoi' => $item['chisonuocmoi'],
                ]);
                if ($result['success']) $count++;
            }

            return $this->traVeThanhCong("Đã xử lý thành công $count phòng.");
        });
    }

    public function duLieuNhapHangLoat(): array
    {
        $phongs = Phong::with(['loaiphong', 'toanha'])
            ->whereHas('giuongs', fn($q) => $q->where('trang_thai', BedStatus::Occupied))
            ->get();

        $phongIds = $phongs->pluck('id');

        $lastDienList = ChiSoDienNuoc::whereIn('phong_id', $phongIds)
            ->where('loai', 'dien')
            ->orderByDesc('nam')
            ->orderByDesc('thang')
            ->get()
            ->groupBy('phong_id');

        $lastNuocList = ChiSoDienNuoc::whereIn('phong_id', $phongIds)
            ->where('loai', 'nuoc')
            ->orderByDesc('nam')
            ->orderByDesc('thang')
            ->get()
            ->groupBy('phong_id');

        $phongs->map(function ($phong) use ($lastDienList, $lastNuocList) {
            $phong->chisodiencu = $lastDienList->get($phong->id)?->first()?->chi_so_moi ?? 0;
            $phong->chisonuoccu = $lastNuocList->get($phong->id)?->first()?->chi_so_moi ?? 0;
            return $phong;
        });

        return [
            'danhsachphong' => $phongs,
            'thangHienTai' => now()->month,
            'namHienTai' => now()->year,
            'bangGia' => $this->layBangGia(),
        ];
    }

    // ─── Private Helpers ──────────────────────────────────────────────────────

    protected function thongBaoPhong(int $phongId, ?Hoadon $hoadon): void
    {
        if (app()->environment('testing')) {
            return;
        }

        $sinhviens = Sinhvien::whereHas('current_hopdong', fn($q) =>
            $q->where('phong_id', $phongId)
        )->with('user')->get();

        foreach ($sinhviens as $s) {
            if ($s->user && $hoadon) {
                $s->user->notify(new HoadonMoiNotification($hoadon));
            }
        }
    }

    private function layGiaTuCauhinh(string $key, string $defaultValue): string
    {
        if (app()->environment('testing')) {
            return match($key) {
                'gia_dien' => '3500',
                'gia_nuoc' => '15000',
                'phi_dich_vu' => '50000',
                'phi_the_chan' => '1000000',
                default => $defaultValue
            };
        }

        return Cache::remember("cauhinh_$key", 3600, function () use ($key, $defaultValue) {
            $c = Cauhinh::where('ten', $key)->first();
            return $c ? $c->giatri : $defaultValue;
        });
    }

    private function layThongTinThanhToanMacDinh(): array
    {
        return [
            'ngan_hang' => $this->layGiaTuCauhinh('ngan_hang', 'VietinBank'),
            'so_tai_khoan' => $this->layGiaTuCauhinh('so_tai_khoan', '123456789'),
            'chu_tai_khoan' => $this->layGiaTuCauhinh('chu_tai_khoan', 'BAN QUAN LY KTX'),
            'email_lien_he' => $this->layGiaTuCauhinh('email_lien_he', 'ktx@phuongdong.edu.vn'),
            'so_dien_thoai_lien_he' => $this->layGiaTuCauhinh('so_dien_thoai_lien_he', ''),
        ];
    }

    private function layThongTinThanhToanChoHoaDon(Sinhvien $sinhvien, Hoadon $hoadon): array
    {
        $macDinh = $this->layThongTinThanhToanMacDinh();

        return [
            ...$macDinh,
            'so_tien' => (int) $hoadon->tong_tien,
            'noi_dung_ck' => 'HD ' . $hoadon->ma_hoa_don . ' ' . ($sinhvien->ma_sinh_vien ?? ('SV' . $sinhvien->id)),
        ];
    }

    private function buildAmounts(int $tienPhong, int $tienDien, int $tienNuoc, int $phiDichVu): array
    {
        $tongTien = $tienPhong + $tienDien + $tienNuoc + $phiDichVu;

        return [
            'tien_phong' => $tienPhong,
            'tien_dien' => $tienDien,
            'tien_nuoc' => $tienNuoc,
            'phi_dich_vu' => $phiDichVu,
            'tong_tien' => $tongTien,
        ];
    }

    private function generateInvoiceCode(string $prefix): string
    {
        return $prefix . '-' . strtoupper(Str::random(8));
    }
}
