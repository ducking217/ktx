<?php

namespace App\Services\Admin;

use App\Contracts\Admin\HoanTienServiceInterface;
use App\Models\Hopdong;
use App\Models\Hoadon;
use App\Enums\InvoiceStatus;
use Illuminate\Support\Facades\Log;

class HoanTienService implements HoanTienServiceInterface
{
    public function xuLyHoanTien(Hopdong $hopdong, int $phiHuHai = 0): array
    {
        try {
            // Tìm hóa đơn cọc đã thanh toán của hợp đồng này
            // Vì Hoadon không có hopdong_id, ta tìm qua sinhvien_id, phong_id và loai_hoadon
            $hoadonCoc = Hoadon::where('sinhvien_id', $hopdong->sinhvien_id)
                ->where('phong_id', $hopdong->phong_id)
                ->where('loai_hoadon', Hoadon::LOAI_DEPOSIT)
                ->where('trangthaithanhtoan', InvoiceStatus::Paid->value)
                ->first();

            if (!$hoadonCoc) {
                // Có thể sinh viên cũ không có hóa đơn cọc, hoặc chưa thanh toán cọc
                return ['success' => true, 'message' => 'Không tìm thấy hóa đơn cọc để hoàn tiền.'];
            }

            $tienCoc = (int) $hoadonCoc->tongtien;

            // Xử lý logic phạt > cọc
            if ($phiHuHai > $tienCoc) {
                $tienNo = $phiHuHai - $tienCoc;
                
                // Tạo hóa đơn phạt cho phần nợ còn lại, đã cấn trừ tiền cọc
                Hoadon::create([
                    'sinhvien_id' => $hopdong->sinhvien_id,
                    'phong_id' => $hopdong->phong_id,
                    'thang' => now()->month,
                    'nam' => now()->year,
                    'tongtien' => $tienNo,
                    'loai_hoadon' => Hoadon::LOAI_PENALTY,
                    'trangthaithanhtoan' => InvoiceStatus::Pending->value,
                    'ngayxuat' => now()->format('Y-m-d'),
                    'ghichu' => "Phạt hư hại/vi phạm: " . number_format($phiHuHai) . "đ. Đã cấn trừ " . number_format($tienCoc) . "đ từ tiền cọc. Còn nợ: " . number_format($tienNo) . "đ."
                ]);

                return ['success' => true, 'message' => 'Phí hư hại lớn hơn tiền cọc. Đã tạo hóa đơn thu thêm.'];
            }

            // Xử lý logic phạt <= cọc (Có tiền hoàn)
            $tienHoan = $tienCoc - $phiHuHai;

            if ($phiHuHai > 0) {
                // Có phạt nhưng nằm trong cọc -> Tạo hóa đơn phạt và đánh dấu Đã thanh toán (Paid)
                Hoadon::create([
                    'sinhvien_id' => $hopdong->sinhvien_id,
                    'phong_id' => $hopdong->phong_id,
                    'thang' => now()->month,
                    'nam' => now()->year,
                    'tongtien' => $phiHuHai,
                    'loai_hoadon' => Hoadon::LOAI_PENALTY,
                    'trangthaithanhtoan' => InvoiceStatus::Paid->value,
                    'ngayxuat' => now()->format('Y-m-d'),
                    'ngaythanhtoan' => now()->format('Y-m-d'),
                    'ghichu' => "Phạt hư hại/vi phạm. Đã cấn trừ trực tiếp vào tiền cọc."
                ]);
            }

            if ($tienHoan > 0) {
                // Trả lại phần dư cho sinh viên
                Hoadon::create([
                    'sinhvien_id' => $hopdong->sinhvien_id,
                    'phong_id' => $hopdong->phong_id,
                    'thang' => now()->month,
                    'nam' => now()->year,
                    'tongtien' => $tienHoan,
                    'loai_hoadon' => Hoadon::LOAI_REFUND,
                    'trangthaithanhtoan' => InvoiceStatus::Pending->value, // Chờ kế toán thanh toán
                    'ngayxuat' => now()->format('Y-m-d'),
                    'ghichu' => "Hoàn tiền thế chân. Tổng cọc: " . number_format($tienCoc) . "đ. Phí hư hại: " . number_format($phiHuHai) . "đ."
                ]);
            }

            return ['success' => true, 'message' => 'Đã xử lý hoàn cọc thành công.'];
        } catch (\Throwable $e) {
            Log::error("Refund error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Lỗi xử lý hoàn tiền: ' . $e->getMessage()];
        }
    }
}
