<?php

namespace App\Services\Admin;

use App\Contracts\Admin\HoanTienServiceInterface;
use App\Models\Hopdong;
use App\Models\Hoadon;
use App\Enums\InvoiceStatus;
use Illuminate\Support\Facades\Log;

/**

 * Khu vực: Admin / Hoàn tiền
 
 * Vai trò: Xử lý hoàn cọc/hoàn tiền khi thanh lý hợp đồng, kèm các điều kiện cấn trừ.

 */

class HoanTienService implements HoanTienServiceInterface
{
    public function xuLyHoanTien(Hopdong $hopdong, int $phiHuHai = 0): array
    {
        try {
            // Tìm hóa đơn cọc đã thanh toán của hợp đồng này
            $hoadonCoc = Hoadon::where('hopdong_id', $hopdong->id)
                ->where('loai_hoadon', Hoadon::LOAI_DEPOSIT)
                ->where('trang_thai', InvoiceStatus::Paid->value)
                ->first();

            if (!$hoadonCoc) {
                return ['success' => true, 'message' => 'Không tìm thấy hóa đơn cọc để hoàn tiền.'];
            }

            $tienCoc = (int) $hoadonCoc->tong_tien;

            // Xử lý logic phạt > cọc
            if ($phiHuHai > $tienCoc) {
                $tienNo = $phiHuHai - $tienCoc;
                
                // Tạo hóa đơn phạt cho phần nợ còn lại, đã cấn trừ tiền cọc
                Hoadon::create([
                    'hopdong_id' => $hopdong->id,
                    'phong_id' => $hopdong->giuong?->phong_id,
                    'ma_hoa_don' => 'PENALTY-' . \Illuminate\Support\Str::random(8),
                    'tien_phong' => 0,
                    'tien_dien' => 0,
                    'tien_nuoc' => 0,
                    'phi_dich_vu' => $tienNo,
                    'tong_tien' => $tienNo,
                    'loai_hoadon' => Hoadon::LOAI_EXTRA,
                    'trang_thai' => InvoiceStatus::Unpaid->value,
                    'ngay_het_han' => now()->addDays(7),
                    'ghi_chu' => "Phí hư hại/vi phạm: " . number_format($phiHuHai) . "đ. Đã cấn trừ " . number_format($tienCoc) . "đ từ tiền cọc. Còn nợ: " . number_format($tienNo) . "đ.",
                ]);

                return ['success' => true, 'message' => 'Phí hư hại lớn hơn tiền cọc. Đã tạo hóa đơn thu thêm.'];
            }

            // Xử lý logic phạt <= cọc (Có tiền hoàn)
            $tienHoan = $tienCoc - $phiHuHai;

            if ($phiHuHai > 0) {
                // Có phạt nhưng nằm trong cọc -> Tạo hóa đơn phạt và đánh dấu Đã thanh toán (Paid)
                Hoadon::create([
                    'hopdong_id' => $hopdong->id,
                    'phong_id' => $hopdong->giuong?->phong_id,
                    'ma_hoa_don' => 'PENALTY-' . \Illuminate\Support\Str::random(8),
                    'tien_phong' => 0,
                    'tien_dien' => 0,
                    'tien_nuoc' => 0,
                    'phi_dich_vu' => $phiHuHai,
                    'tong_tien' => $phiHuHai,
                    'loai_hoadon' => Hoadon::LOAI_EXTRA,
                    'trang_thai' => InvoiceStatus::Paid->value,
                    'ngay_thanh_toan' => now(),
                    'ghi_chu' => 'Phí hư hại/vi phạm. Đã cấn trừ trực tiếp vào tiền cọc.',
                ]);
            }

            if ($tienHoan > 0) {
                // Trả lại phần dư cho sinh viên
                Hoadon::create([
                    'hopdong_id' => $hopdong->id,
                    'phong_id' => $hopdong->giuong?->phong_id,
                    'ma_hoa_don' => 'REFUND-' . \Illuminate\Support\Str::random(8),
                    'tien_phong' => 0,
                    'tien_dien' => 0,
                    'tien_nuoc' => 0,
                    'phi_dich_vu' => $tienHoan,
                    'tong_tien' => $tienHoan,
                    'loai_hoadon' => Hoadon::LOAI_REFUND,
                    'trang_thai' => InvoiceStatus::Unpaid->value, // Chờ kế toán thanh toán
                    'ngay_het_han' => now()->addDays(7),
                    'ghi_chu' => "Hoàn tiền thế chân. Tổng cọc: " . number_format($tienCoc) . "đ. Phí hư hại: " . number_format($phiHuHai) . "đ.",
                ]);
            }

            return ['success' => true, 'message' => 'Đã xử lý hoàn cọc thành công.'];
        } catch (\Throwable $e) {
            Log::error('HoanTienService.xuLyHoanTien failed', ['hopdong_id' => $hopdong->id ?? null, 'exception' => $e]);
            $message = config('app.debug') ? ('Lỗi xử lý hoàn tiền: ' . $e->getMessage()) : 'Lỗi xử lý hoàn tiền.';
            return ['success' => false, 'message' => $message];
        }
    }
}
