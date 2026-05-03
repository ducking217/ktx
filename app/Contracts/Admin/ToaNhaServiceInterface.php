<?php

declare(strict_types=1);

namespace App\Contracts\Admin;

use App\Models\ToaNha;
use Illuminate\Database\Eloquent\Collection;

interface ToaNhaServiceInterface
{
    /**
     * Lấy danh sách tòa nhà kèm số lượng phòng.
     */
    public function danhSach(): Collection;

    /**
     * Tìm kiếm tòa nhà theo ID.
     */
    public function timKiem(int $id): ToaNha;

    /**
     * Lưu tòa nhà mới.
     */
    public function luu(array $data): ToaNha;

    /**
     * Cập nhật thông tin tòa nhà.
     */
    public function capNhat(ToaNha $toaNha, array $data): ToaNha;

    /**
     * Xóa tòa nhà khỏi hệ thống.
     * 
     * @throws \Exception Nếu tòa nhà còn phòng đang hoạt động.
     */
    public function xoa(ToaNha $toaNha): void;
}
