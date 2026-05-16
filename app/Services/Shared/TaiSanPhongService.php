<?php

namespace App\Services\Shared;

use App\Contracts\Shared\TaiSanPhongServiceInterface;
use App\Models\Taisan;

/**

 * Khu vực: Shared / Tài sản phòng
 
 * Vai trò: CRUD/gắn tài sản theo phòng và hỗ trợ thao tác hàng loạt.

 */

class TaiSanPhongService implements TaiSanPhongServiceInterface
{
    public function store(array $data, int $phongId): array
    {
        $tenTaiSan = $data['ten_tai_san'] ?? $data['tentaisan'] ?? null;
        $soLuong = $data['so_luong'] ?? $data['soluong'] ?? null;
        $tinhTrang = $data['tinh_trang'] ?? $data['tinhtrang'] ?? null;

        Taisan::create([
            'phong_id' => $phongId,
            'ten_tai_san' => $tenTaiSan,
            'so_luong' => $soLuong,
            'tinh_trang' => $tinhTrang,
        ]);

        return ['success' => true, 'message' => 'Thêm tài sản thành công.'];
    }

    public function update(array $data, int $phongId, int $taisanId): array
    {
        $taisan = Taisan::where('phong_id', $phongId)->find($taisanId);
        if (! $taisan) {
            return ['success' => false, 'message' => 'Không tìm thấy tài sản cần cập nhật.'];
        }

        $taisan->update([
            'ten_tai_san' => $data['ten_tai_san'] ?? $taisan->ten_tai_san,
            'so_luong' => $data['so_luong'] ?? $taisan->so_luong,
            'tinh_trang' => $data['tinh_trang'] ?? $taisan->tinh_trang,
        ]);

        return ['success' => true, 'message' => 'Cập nhật tài sản thành công.'];
    }

    public function destroy(int $phongId, int $taisanId): array
    {
        $taisan = Taisan::where('phong_id', $phongId)->find($taisanId);
        if (! $taisan) {
            return ['success' => false, 'message' => 'Không tìm thấy tài sản cần xóa.'];
        }

        $taisan->delete();

        return ['success' => true, 'message' => 'Xóa tài sản thành công.'];
    }
}
