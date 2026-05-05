<?php

namespace App\Services\Core;

use App\Contracts\Core\KiemToanServiceInterface;
use App\Models\NhatKy;
use Illuminate\Support\Facades\Auth;

class KiemToanService implements KiemToanServiceInterface
{
    /**
     * Log một hành động thay đổi
     */
    public function ghiNhatKy(string $hanhDong, string $tenModel, int $idBanGhi, ?array $duLieuCu = null, ?array $duLieuMoi = null): void
    {
        NhatKy::create([
            'user_id' => Auth::id(),
            'hanh_dong' => $hanhDong, // create/update/delete
            'ten_model' => $tenModel,
            'id_ban_ghi' => $idBanGhi,
            'du_lieu_cu' => $duLieuCu,
            'du_lieu_moi' => $duLieuMoi,
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Log thay đổi trạng thái hợp đồng
     */
    public function ghiNhatKyThayDoiTrangThaiHopDong(int $hopdongId, string $trangThaiCu, string $trangThaiMoi): void
    {
        $this->ghiNhatKy(
            'update',
            'Hopdong',
            $hopdongId,
            ['trang_thai' => $trangThaiCu],
            ['trang_thai' => $trangThaiMoi]
        );
    }

    /**
     * Log thay đổi trạng thái thanh toán hóa đơn
     */
    public function ghiNhatKyThayDoiTrangThaiThanhToanHoaDon(int $hoadonId, string $trangThaiCu, string $trangThaiMoi): void
    {
        $this->ghiNhatKy(
            'update',
            'Hoadon',
            $hoadonId,
            ['trang_thai' => $trangThaiCu],
            ['trang_thai' => $trangThaiMoi]
        );
    }

    /**
     * Log chuyển phòng sinh viên
     */
    public function ghiNhatKyDoiPhong(int $sinhvienId, int $phongCu, int $phongMoi): void
    {
        // Trong v2, việc đổi phòng được quản lý qua Hopdong -> Giuong -> Phong.
        // Log này hiện tại chỉ mang tính tham khảo hoặc cần refactor sâu hơn để ghi nhận chuyển giường.
        $this->ghiNhatKy(
            'change_room_context',
            'Sinhvien',
            $sinhvienId,
            ['context' => 'Chuyển từ phòng ID ' . $phongCu],
            ['context' => 'Sang phòng ID ' . $phongMoi]
        );
    }

    /**
     * Log gia hạn hợp đồng
     */
    public function ghiNhatKyGiaHanHopDong(int $hopdongId, string $ngayKetThucCu, string $ngayKetThucMoi): void
    {
        $this->ghiNhatKy(
            'update',
            'Hopdong',
            $hopdongId,
            ['ngay_ket_thuc' => $ngayKetThucCu],
            ['ngay_ket_thuc' => $ngayKetThucMoi]
        );
    }
}
