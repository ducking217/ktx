<?php

namespace App\Services\Admin;

use App\Contracts\Admin\TaiChinhServiceInterface;
use App\Enums\InvoiceStatus;
use App\Models\Hoadon;
use App\Models\Phong;
use App\Models\Thongbao;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;

/**

 * Khu vực: Admin / Tài chính
 
 * Vai trò: Nghiệp vụ tài chính tổng hợp phục vụ màn quản trị/điều phối.

 */

class TaiChinhService implements TaiChinhServiceInterface
{
    use PhanHoiService;

    public function nhacNo(int $invoiceId): array
    {
        try {
            $hoadon = Hoadon::with(['hopdong.sinhvien.user', 'phong'])->find($invoiceId);
            if (! $hoadon) {
                return $this->traVeLoi('Không tìm thấy hóa đơn.');
            }

            $tenPhong = $hoadon->phong?->ten_phong ?? $hoadon->hopdong?->giuong?->phong?->ten_phong;

            Thongbao::create([
                'tieu_de' => 'Nhắc nhở thanh toán công nợ',
                'noi_dung' => "Vui lòng thanh toán hóa đơn #{$hoadon->id}"
                    . ($tenPhong ? " (Phòng {$tenPhong})" : '')
                    . ' trị giá ' . number_format((int) $hoadon->tong_tien) . 'đ.',
                'loai_thong_bao' => 'finance',
                'doi_tuong_nhan' => 'sinhvien',
            ]);

            return $this->traVeThanhCong('Đã gửi thông báo nhắc nợ.');
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }
}
