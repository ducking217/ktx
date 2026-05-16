<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Enums\BedStatus;
use App\Enums\ContractStatus;
use App\Enums\InvoiceStatus;
use App\Contracts\Admin\HopdongServiceInterface;
use App\Contracts\Admin\HoanTienServiceInterface;
use App\Models\Giuong;
use App\Models\Hoadon;
use App\Models\Hopdong;
use App\Models\Sinhvien;
use App\Traits\HoTroNghiepVu;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**

 * Khu vực: Admin / Hợp đồng
 
 * Vai trò: Quản lý vòng đời hợp đồng (tạo, gia hạn, thanh lý) và trạng thái giường liên quan.

 */

class HopdongService implements HopdongServiceInterface
{
    use HoTroNghiepVu, PhanHoiService;

    public function __construct(
        private readonly HoanTienServiceInterface $hoanTienService
    ) {}

    public function lietKeHopDongAdmin(Request $request): array
    {
        $tuKhoa = (string) $request->query('q', $request->query('search', ''));
        $trangThai = (string) $request->query('trangthai', $request->query('status', 'Tất cả'));
        if ($trangThai === '') {
            $trangThai = 'Tất cả';
        }

        $contracts = Hopdong::query()
            ->select([
                'id',
                'sinhvien_id',
                'giuong_id',
                'phong_id',
                'ngay_bat_dau',
                'ngay_ket_thuc',
                'gia_thuc_te',
                'trang_thai',
                'ghi_chu as ghichu',
                'created_at',
            ])
            ->with([
                'sinhvien:id,user_id,ma_sinh_vien',
                'sinhvien.user:id,name',
                'giuong:id,phong_id',
                'giuong.phong:id,toa_nha_id,ten_phong',
                'giuong.phong.toanha:id,ten_toa_nha',
            ])
            ->when($tuKhoa, function ($q) use ($tuKhoa) {
                $q->whereHas('sinhvien', fn($sq) => $sq->where('ma_sinh_vien', 'like', '%' . \App\Helpers\SecurityHelper::escapeLike($tuKhoa) . '%')
                    ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', '%' . \App\Helpers\SecurityHelper::escapeLike($tuKhoa) . '%')));
            })
            ->when($trangThai !== 'Tất cả', fn($q) => $q->where('trang_thai', $trangThai))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        $contractIds = $contracts->getCollection()->pluck('id')->filter()->values()->all();
        if (! empty($contractIds)) {
            $depositMap = Hoadon::query()
                ->selectRaw('hopdong_id, MAX(tong_tien) as tien_coc')
                ->whereIn('hopdong_id', $contractIds)
                ->where('loai_hoadon', Hoadon::LOAI_DEPOSIT)
                ->where('trang_thai', InvoiceStatus::Paid->value)
                ->groupBy('hopdong_id')
                ->pluck('tien_coc', 'hopdong_id');

            $contracts->getCollection()->each(function ($hopdong) use ($depositMap): void {
                $hopdong->tien_coc = (int) ($depositMap[$hopdong->id] ?? 0);
            });
        }

        return ['hopdong' => $contracts, 'tuKhoa' => $tuKhoa, 'trangThai' => $trangThai];
    }

    public function lietKeHopDongSinhVien(): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
        if (!$sinhvien) return ['hopdong' => collect()];

        return [
            'hopdong' => Hopdong::where('sinhvien_id', $sinhvien->id)
                ->with(['giuong.phong.toanha'])
                ->orderByDesc('created_at')
                ->get()
        ];
    }

    public function layChiTietHopDong(int $id): array
    {
        $hopdong = Hopdong::with(['sinhvien.user', 'giuong.phong.toanha'])->find($id);
        return $hopdong
            ? ['hopdong' => $hopdong]
            : $this->traVeLoi('Không tìm thấy hợp đồng.');
    }

    /**
     * Tạo hợp đồng thủ công (Admin chủ động xếp giường cho sinh viên).
     * Smart Auto-Assign: Ưu tiên giuong_id, fallback phong_id.
     */
    public function taoHopDong(array $data): array
    {
        try {
            return DB::transaction(function () use ($data) {
                $sinhvien = Sinhvien::where('id', (int) $data['sinhvien_id'])->lockForUpdate()->first();
                if (!$sinhvien) {
                    return $this->traVeLoi('Sinh viên không tồn tại.');
                }

                // Smart Auto-Assign Logic: Ưu tiên giuong_id
                $giuong = null;
                $phong_id = null;

                // Case 1: Có giuong_id -> Validate và suy ra phong_id
                if (isset($data['giuong_id'])) {
                    $giuong = Giuong::where('id', (int) $data['giuong_id'])->lockForUpdate()->first();
                    if (!$giuong) {
                        return $this->traVeLoi('Giường không tồn tại.');
                    }

                    $phong_id = $giuong->phong_id;

                    // Validation: Nếu cũng có phong_id, kiểm tra mapping nghiêm ngặt
                    if (isset($data['phong_id']) && (int) $data['phong_id'] !== $phong_id) {
                        return $this->traVeLoi('Giường không thuộc phòng đã chọn');
                    }
                }
                
                // Case 2: Chỉ có phong_id -> Auto-assign giường trống đầu tiên
                elseif (isset($data['phong_id'])) {
                    $phong_id = (int) $data['phong_id'];
                    
                    $giuong = Giuong::where('phong_id', $phong_id)
                        ->where('trang_thai', BedStatus::Available->value)
                        ->lockForUpdate()
                        ->first();
                        
                    if (!$giuong) {
                        return $this->traVeLoi('Phòng không có giường trống.');
                    }
                }
                
                else {
                    return $this->traVeLoi('Phải cung cấp ít nhất giuong_id hoặc phong_id.');
                }

                $check = $this->validateNewContract($sinhvien, $giuong);
                if (!$check['success']) return $check;

                // Giá thực tế = giá của Loại phòng tại thời điểm ký
                $giaThucTe = $giuong->phong->loaiphong->gia_thang ?? 0;

                $contract = Hopdong::create([
                    'sinhvien_id'  => $sinhvien->id,
                    'phong_id'     => $phong_id,        // ← ĐẢM BẢO CẢ HAI ID
                    'giuong_id'    => $giuong->id,
                    'ngay_bat_dau' => $data['ngay_bat_dau'],
                    'ngay_ket_thuc' => $data['ngay_ket_thuc'],
                    'gia_thuc_te'  => $giaThucTe,
                    'trang_thai'   => ContractStatus::Active->value,
                ]);

                // Cập nhật trạng thái giường → đã có người ở (cùng transaction)
                $giuong->update(['trang_thai' => BedStatus::Occupied->value]);

                return $this->traVeThanhCong('Tạo hợp đồng thành công.', ['contract' => $contract]);
            });
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    public function giaHanHopDong(int $contractId, string $newEndDate, string $currentEndDate): array
    {
        try {
            return DB::transaction(function () use ($contractId, $newEndDate, $currentEndDate) {
                $hopdong = Hopdong::lockForUpdate()->find($contractId);
                if (!$hopdong) return $this->traVeLoi('Không tìm thấy hợp đồng.');

                if ($hopdong->trang_thai !== ContractStatus::Active->value) {
                    return $this->traVeLoi('Chỉ có thể gia hạn hợp đồng đang hoạt động.');
                }

                if (strtotime($newEndDate) <= strtotime($currentEndDate)) {
                    return $this->traVeLoi('Ngày gia hạn phải sau ngày hết hạn hiện tại.');
                }

                $oldEndDate = $hopdong->ngay_ket_thuc;
                 $hopdong->update(['ngay_ket_thuc' => $newEndDate]);
                 
                 // Sử dụng KiemToanService
                 app(\App\Contracts\Core\KiemToanServiceInterface::class)->ghiNhatKyGiaHanHopDong(
                     $hopdong->id, 
                     (string)$oldEndDate, 
                     $newEndDate
                 );

                return $this->traVeThanhCong('Gia hạn hợp đồng thành công.');
            });
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    public function thanhLyHopDong(int $contractId, int $phiHuHai = 0): array
    {
        return DB::transaction(function () use ($contractId, $phiHuHai) {
            $hopdong = Hopdong::with('giuong')->lockForUpdate()->find($contractId);

            if (!$hopdong || $hopdong->trang_thai === ContractStatus::Terminated) {
                return $this->traVeLoi('Hợp đồng không hợp lệ hoặc đã được thanh lý.');
            }

            if (!$hopdong->transitionTo(ContractStatus::Terminated->value)) {
                throw new \Exception('Không thể chuyển đổi trạng thái hợp đồng.');
            }

            // Giải phóng giường
            if ($hopdong->giuong) {
                $hopdong->giuong->update(['trang_thai' => BedStatus::Available]);
            }

            // Kích hoạt tính toán hoàn tiền
            $this->hoanTienService->xuLyHoanTien($hopdong, $phiHuHai);

            return $this->traVeThanhCong('Thanh lý hợp đồng thành công.');
        });
    }

    // ─── Private Helpers ──────────────────────────────────────────────────────

    private function validateNewContract(Sinhvien $sinhvien, Giuong $giuong): array
    {
        // Kiểm tra sinh viên đã có hợp đồng active chưa
        if (Hopdong::where('sinhvien_id', $sinhvien->id)
            ->where('trang_thai', ContractStatus::Active->value)
            ->exists()) {
            return $this->traVeLoi('Sinh viên đang có hợp đồng hoạt động.');
        }

        // Kiểm tra giường có trống không
        if ($giuong->trang_thai !== BedStatus::Available) {
            return $this->traVeLoi('Giường này hiện không trống.');
        }

        return ['success' => true];
    }
}
