<?php

namespace App\Services\Shared;

use App\Contracts\Shared\VatTuPhongServiceInterface;
use App\Models\Vattu;

/**

 * Khu vực: Shared / Vật tư phòng
 
 * Vai trò: CRUD/gắn vật tư theo phòng và hỗ trợ thao tác hàng loạt.

 */

class VatTuPhongService implements VatTuPhongServiceInterface
{
    public function store(array $data, int $phongId): array
    {
        Vattu::create([
            'phong_id' => $phongId,
            'ten_vat_tu' => $data['ten_vat_tu'],
            'so_luong' => $data['so_luong'],
            'tinh_trang' => $data['tinh_trang'],
            'mo_ta' => $data['mo_ta'] ?? null,
            'ngay_mua' => $data['ngay_mua'] ?? null,
            'thoi_gian_bao_hanh' => $data['thoi_gian_bao_hanh'] ?? null,
        ]);

        return ['success' => true, 'message' => 'Thêm vật tư thành công.'];
    }

    public function update(array $data, int $phongId, int $vattuId): array
    {
        $vattu = Vattu::where('phong_id', $phongId)->find($vattuId);
        if (! $vattu) {
            return ['success' => false, 'message' => 'Không tìm thấy vật tư cần cập nhật.'];
        }

        $vattu->update([
            'ten_vat_tu' => $data['ten_vat_tu'] ?? $vattu->ten_vat_tu,
            'so_luong' => $data['so_luong'] ?? $vattu->so_luong,
            'tinh_trang' => $data['tinh_trang'] ?? $vattu->tinh_trang,
            'mo_ta' => $data['mo_ta'] ?? $vattu->mo_ta,
            'ngay_mua' => $data['ngay_mua'] ?? $vattu->ngay_mua,
            'thoi_gian_bao_hanh' => $data['thoi_gian_bao_hanh'] ?? $vattu->thoi_gian_bao_hanh,
        ]);

        return ['success' => true, 'message' => 'Cập nhật vật tư thành công.'];
    }

    public function destroy(int $phongId, int $vattuId): array
    {
        $vattu = Vattu::where('phong_id', $phongId)->find($vattuId);
        if (! $vattu) {
            return ['success' => false, 'message' => 'Không tìm thấy vật tư cần xóa.'];
        }

        $vattu->delete();

        return ['success' => true, 'message' => 'Xóa vật tư thành công.'];
    }
}
