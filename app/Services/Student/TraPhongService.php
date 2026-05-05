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
        $hopdongIds = $sinhvien->hopdongs()->pluck('id')->all();
        if (empty($hopdongIds)) {
            return ['has_debt' => false, 'count' => 0, 'invoices' => collect()];
        }

        $pending = Hoadon::whereIn('hopdong_id', $hopdongIds)
            ->whereIn('trang_thai', [InvoiceStatus::Unpaid->value, InvoiceStatus::Overdue->value])
            ->get();

        return ['has_debt' => $pending->count() > 0, 'count' => $pending->count(), 'invoices' => $pending];
    }

    public function xuLyTraPhong(int $contractId): array
    {
        try {
            return DB::transaction(function () use ($contractId) {
                $hopdong = Hopdong::with(['sinhvien.user', 'giuong.phong'])->lockForUpdate()->find($contractId);
                if (!$hopdong) return $this->traVeLoi('Không tìm thấy hợp đồng.');

                $sinhvien = $hopdong->sinhvien;
                $debtStatus = $this->kiemTraNo($sinhvien);
                if ($debtStatus['has_debt']) return $this->traVeLoi("Còn {$debtStatus['count']} hóa đơn chưa thanh toán.");

                $oldData = $hopdong->toArray();
                
                // Sử dụng HopdongService để thực hiện thanh lý chuẩn v2
                $result = $this->contractService->thanhLyHopDong($contractId);
                
                if (!$result['success']) {
                    return $result;
                }

                $this->ghiNhatKyTraPhong($contractId, $oldData);

                return $this->traVeThanhCong('Thanh lý thành công. ' . ($result['message'] ?? ''));
            });
        } catch (\Exception $e) {
            Log::error("Checkout failed: " . $e->getMessage());
            return $this->traVeLoi('Lỗi: ' . $e->getMessage());
        }
    }

    private function ghiNhatKyTraPhong(int $id, array $oldData)
    {
        $this->kiemToanService->ghiNhatKy(
            'Thanh lý hợp đồng',
            'Hopdong',
            $id,
            $oldData,
            ['trang_thai' => ContractStatus::Terminated->value]
        );
    }
}
