<?php

namespace App\Contracts\Core;

use Illuminate\Http\Request;

interface TienIchServiceInterface
{
    /**
     * Lấy cấu hình hệ thống.
     */
    public function layCauHinh(): array;

    /**
     * Cập nhật cấu hình.
     */
    public function capNhatCauHinh(array $data): void;

    /**
     * Lấy danh sách thông báo.
     */
    public function danhSachThongBao(string $target = 'all'): array;

    /**
     * Gửi thông báo.
     */
    public function guiThongBao(array $data): void;

    /**
     * Danh sách liên hệ (Admin).
     */
    public function danhSachLienHe(Request $request): array;

    /**
     * Cập nhật trạng thái liên hệ.
     */
    public function capNhatTrangThaiLienHe(int $id, string $status, ?string $note = null): void;
}
