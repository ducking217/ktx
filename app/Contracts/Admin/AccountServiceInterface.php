<?php

declare(strict_types=1);

namespace App\Contracts\Admin;

use Illuminate\Http\Request;

interface AccountServiceInterface
{
    /**
     * Danh sách tài khoản quản trị.
     */
    public function lietKe(Request $request): array;

    /**
     * Lưu tài khoản mới.
     */
    public function luu(array $data): array;

    /**
     * Cập nhật tài khoản.
     */
    public function capNhat(int $id, array $data): array;

    /**
     * Xóa tài khoản (Soft Delete).
     */
    public function xoa(int $id): array;
}
