<?php

namespace App\Contracts\Admin;

use Illuminate\Http\Request;

interface DangkyServiceInterface
{
    /**
     * Gửi đăng ký phòng mới (Sinh viên).
     */
    public function luuDangKySinhVien(array $data): array;

    /**
     * Gửi yêu cầu trả phòng (Sinh viên).
     */
    public function yeuCauTraPhong(?string $reason = null): array;

    /**
     * Lấy danh sách đăng ký cho Admin.
     */
    public function lietKeDangKyAdmin(Request $request): array;

    /**
     * Từ chối đăng ký (Admin).
     */
    public function tuChoiDangKy(int $id, ?string $reason): array;

    /**
     * Duyệt hồ sơ (Admin).
     */
    public function duyetHoSo(int $id): array;

    /**
     * Xác nhận thanh toán (Admin).
     */
    public function xacNhanThanhToan(int $id): array;

    /**
     * Đăng ký cho khách (Guest).
     */
    public function luuDangkyKhach(array $data): array;

    /**
     * Lấy dữ liệu form đăng ký cho khách.
     */
    public function layDuLieuFormDangKyKhach(int $phongId): array;

    /**
     * Tra cuu ho so dang ky theo token.
     */
    public function layDuLieuTraCuuKhach(?string $token): array;

    /**
     * Duyệt đăng ký (Admin) - Tạo hợp đồng tự động.
     */
    public function duyetDangKy(int $id, ?string $ngayHetHan = null): array;

    /**
     * Xử lý yêu cầu trả phòng (Admin) - Thanh lý hợp đồng và giải phóng giường.
     */
    public function xuLyYeuCauTraPhong(int $dangkyId): array;

    /**
     * Từ chối yêu cầu trả phòng (Admin).
     */
    public function tuChoiYeuCauTraPhong(int $dangkyId, ?string $reason): array;
}
