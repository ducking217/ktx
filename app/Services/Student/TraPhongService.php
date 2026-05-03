<?php

declare(strict_types=1);

namespace App\Services\Student;

use App\Contracts\Core\KiemToanServiceInterface;
use App\Models\Hopdong;
use App\Models\Hoadon;
use App\Models\Sinhvien;
use App\Enums\ContractStatus;
use App\Enums\InvoiceStatus;
use App\Traits\PhanHoiService;
use App\Contracts\Student\TraPhongServiceInterface;
use App\Contracts\Admin\HoanTienServiceInterface;
use App\Services\Admin\HopdongService;
use App\Services\Admin\HoadonService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TraPhongService implements TraPhongServiceInterface
{
    use PhanHoiService;

    public function __construct(
        private readonly HopdongService $contractService,
        private readonly HoadonService $invoiceService,
        private readonly HoanTienServiceInterface $refundService,
        private readonly KiemToanServiceInterface $kiemToanService
    ) {}

    public function kiemTraNo(Sinhvien $sinhvien): array
    {
        $pending = Hoadon::where('sinhvien_id', $sinhvien->id)->where('trangthaithanhtoan', InvoiceStatus::Pending->value)->get();
        return ['has_debt' => $pending->count() > 0, 'count' => $pending->count(), 'invoices' => $pending];
    }

    public function xuLyTraPhong(int $contractId): array
    {
        try {
            return DB::transaction(function () use ($contractId) {
                $hopdong = Hopdong::with(['sinhvien.taikhoan', 'phong'])->lockForUpdate()->find($contractId);
                if (!$hopdong) return $this->traVeLoi('Không tìm thấy hợp đồng.');

                $sinhvien = $hopdong->sinhvien;
                $debtStatus = $this->kiemTraNo($sinhvien);
                if ($debtStatus['has_debt']) return $this->traVeLoi("Còn {$debtStatus['count']} hóa đơn chưa thanh toán.");

                $oldData = $hopdong->toArray();
                
                // Xử lý hoàn cọc / phạt trước khi thanh lý
                $refundResult = $this->refundService->xuLyHoanTien($hopdong);
                if (!$refundResult['success']) {
                    return $this->traVeLoi($refundResult['message']);
                }

                $this->hoanTatTraPhong($hopdong, $sinhvien);
                $this->ghiNhatKyTraPhong($contractId, $oldData);

                return $this->traVeThanhCong('Thanh lý thành công. ' . $refundResult['message']);
            });
        } catch (\Exception $e) {
            Log::error("Checkout failed: " . $e->getMessage());
            return $this->traVeLoi('Lỗi: ' . $e->getMessage());
        }
    }

    private function hoanTatTraPhong($hopdong, $sinhvien)
    {
        $phongId = $hopdong->phong_id;
        $giuongNo = $sinhvien?->giuong_no;

        $hopdong->update(['trang_thai' => ContractStatus::Terminated->value]);
        if ($sinhvien) {
            $sinhvien->update(['phong_id' => null, 'giuong_no' => null]);
            $sinhvien->taikhoan?->moveToExStudent();
        }

        if ($phongId && $giuongNo) {
            event(new \App\Events\GiuongStatusChanged((int)$phongId, (int)$giuongNo, \App\Enums\BedStatus::Available, \App\Enums\BedStatus::Occupied, 'Thanh lý'));
        }
    }

    private function ghiNhatKyTraPhong(int $id, array $oldData)
    {
        $this->kiemToanService->ghiNhatKy(
            'Thanh lý hợp đồng',
            'Hopdong',
            $id,
            $oldData,
            ['trang_thai' => ContractStatus::Terminated->value, 'sinhvien_phong_id' => null]
        );
    }
}
