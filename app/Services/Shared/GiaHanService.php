<?php

declare(strict_types=1);

namespace App\Services\Shared;

use App\Contracts\Shared\GiaHanServiceInterface;
use App\Enums\ContractStatus;
use App\Enums\ExtensionStatus;
use App\Mail\KetQuaGiaHanHopDongMail;
use App\Models\Hopdong;
use App\Models\Sinhvien;
use App\Models\YeuCauGiaHan;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class GiaHanService implements GiaHanServiceInterface
{
    use PhanHoiService;

    public function lietKeYeuCauSinhVien(): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
        if (! $sinhvien) {
            return ['error' => 'Không tìm thấy thông tin sinh viên.'];
        }

        $yeuCau = YeuCauGiaHan::with(['hopdong.phong'])
            ->where('sinhvien_id', $sinhvien->id)
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return [
            'yeuCauGiaHan' => $yeuCau,
        ];
    }

    public function lietKeYeuCauAdmin(Request $request): array
    {
        $status = $request->query('status', 'Tất cả');

        $query = YeuCauGiaHan::with(['hopdong.phong', 'sinhvien.taikhoan'])
            ->orderByDesc('id');

        if ($status && $status !== 'Tất cả') {
            $query->where('trang_thai', $status);
        }

        return [
            'yeuCauGiaHan' => $query->paginate(20)->withQueryString(),
            'status' => $status,
        ];
    }

    /**
     * @inheritDoc
     */
    public function layHopdongHieuLuc(int $sinhvienId): ?Hopdong
    {
        return Hopdong::with('phong')
            ->where('sinhvien_id', $sinhvienId)
            ->where('trang_thai', ContractStatus::Active->value)
            ->orderByDesc('id')
            ->first();
    }

    public function guiYeuCau(int $hopdongId, string $ngayKetThucMoi, ?string $lyDo): array
    {
        try {
            $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
            if (! $sinhvien) {
                return $this->traVeLoi('Không tìm thấy thông tin sinh viên.');
            }

            return DB::transaction(function () use ($hopdongId, $ngayKetThucMoi, $lyDo, $sinhvien) {
                $hopdong = Hopdong::where('id', $hopdongId)
                    ->where('sinhvien_id', $sinhvien->id)
                    ->lockForUpdate()
                    ->first();

                if (! $hopdong) {
                    return $this->traVeLoi('Không tìm thấy hợp đồng.');
                }

                if (($hopdong->trang_thai instanceof \BackedEnum ? $hopdong->trang_thai->value : (string) $hopdong->trang_thai) !== ContractStatus::Active->value) {
                    return $this->traVeLoi('Chỉ có thể gia hạn hợp đồng đang hiệu lực.');
                }

                $dangCho = YeuCauGiaHan::where('hopdong_id', $hopdong->id)
                    ->where('sinhvien_id', $sinhvien->id)
                    ->where('trang_thai', ExtensionStatus::Pending->value)
                    ->exists();

                if ($dangCho) {
                    return $this->traVeLoi('Bạn đã có yêu cầu gia hạn đang chờ duyệt.');
                }

                YeuCauGiaHan::create([
                    'hopdong_id' => $hopdong->id,
                    'sinhvien_id' => $sinhvien->id,
                    'ngay_ket_thuc_moi' => $ngayKetThucMoi,
                    'ly_do' => $lyDo,
                    'trang_thai' => ExtensionStatus::Pending->value,
                ]);

                return $this->traVeThanhCong('Đã gửi yêu cầu gia hạn. Vui lòng chờ admin xét duyệt.');
            });
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    public function duyetYeuCau(int $yeuCauId, ?string $ghiChuAdmin = null): array
    {
        try {
            $ketQua = DB::transaction(function () use ($yeuCauId, $ghiChuAdmin) {
                $yeuCau = YeuCauGiaHan::with(['hopdong', 'sinhvien.taikhoan'])
                    ->where('id', $yeuCauId)
                    ->lockForUpdate()
                    ->first();

                if (! $yeuCau) {
                    return ['success' => false, 'message' => 'Không tìm thấy yêu cầu gia hạn.'];
                }

                if ($yeuCau->trang_thai !== ExtensionStatus::Pending) {
                    return ['success' => false, 'message' => 'Yêu cầu này đã được xử lý.'];
                }

                $hopdong = Hopdong::where('id', $yeuCau->hopdong_id)->lockForUpdate()->first();
                if (! $hopdong) {
                    return ['success' => false, 'message' => 'Không tìm thấy hợp đồng.'];
                }

                $hopdong->update([
                    'ngay_ket_thuc' => $yeuCau->ngay_ket_thuc_moi->format('Y-m-d'),
                ]);

                // Cập nhật ngày hết hạn của sinh viên để đồng bộ
                $yeuCau->sinhvien->update([
                    'ngay_het_han' => $yeuCau->ngay_ket_thuc_moi->format('Y-m-d'),
                ]);

                $yeuCau->update([
                    'trang_thai' => ExtensionStatus::Approved->value,
                    'ghi_chu_admin' => $ghiChuAdmin,
                ]);

                return ['success' => true, 'yeuCau' => $yeuCau];
            });

            if (! ($ketQua['success'] ?? false)) {
                return $this->traVeLoi($ketQua['message'] ?? 'Không thể duyệt yêu cầu.');
            }

            /** @var YeuCauGiaHan $yeuCau */
            $yeuCau = $ketQua['yeuCau'];
            $email = $yeuCau->sinhvien?->taikhoan?->email;
            if ($email) {
                Mail::to($email)->queue(new KetQuaGiaHanHopDongMail($yeuCau, route('login')));
            }

            return $this->traVeThanhCong('Duyệt yêu cầu gia hạn thành công.');
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    public function tuChoiYeuCau(int $yeuCauId, ?string $ghiChuAdmin = null): array
    {
        try {
            $ketQua = DB::transaction(function () use ($yeuCauId, $ghiChuAdmin) {
                $yeuCau = YeuCauGiaHan::with(['hopdong', 'sinhvien.taikhoan'])
                    ->where('id', $yeuCauId)
                    ->lockForUpdate()
                    ->first();

                if (! $yeuCau) {
                    return ['success' => false, 'message' => 'Không tìm thấy yêu cầu gia hạn.'];
                }

                if ($yeuCau->trang_thai !== ExtensionStatus::Pending) {
                    return ['success' => false, 'message' => 'Yêu cầu này đã được xử lý.'];
                }

                $yeuCau->update([
                    'trang_thai' => ExtensionStatus::Rejected->value,
                    'ghi_chu_admin' => $ghiChuAdmin,
                ]);

                return ['success' => true, 'yeuCau' => $yeuCau];
            });

            if (! ($ketQua['success'] ?? false)) {
                return $this->traVeLoi($ketQua['message'] ?? 'Không thể từ chối yêu cầu.');
            }

            /** @var YeuCauGiaHan $yeuCau */
            $yeuCau = $ketQua['yeuCau'];
            $email = $yeuCau->sinhvien?->taikhoan?->email;
            if ($email) {
                Mail::to($email)->queue(new KetQuaGiaHanHopDongMail($yeuCau, route('login')));
            }

            return $this->traVeThanhCong('Đã từ chối yêu cầu gia hạn.');
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }
}

