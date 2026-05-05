<?php

namespace App\Services\Shared;

use App\Contracts\Shared\VatTuPhongServiceInterface;
use App\Models\Vattu;

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

        return ['success' => true, 'message' => 'Them vat tu thanh cong.'];
    }

    public function update(array $data, int $phongId, int $vattuId): array
    {
        $vattu = Vattu::where('phong_id', $phongId)->find($vattuId);
        if (! $vattu) {
            return ['success' => false, 'message' => 'Khong tim thay vat tu can cap nhat.'];
        }

        $vattu->update([
            'ten_vat_tu' => $data['ten_vat_tu'] ?? $vattu->ten_vat_tu,
            'so_luong' => $data['so_luong'] ?? $vattu->so_luong,
            'tinh_trang' => $data['tinh_trang'] ?? $vattu->tinh_trang,
            'mo_ta' => $data['mo_ta'] ?? $vattu->mo_ta,
            'ngay_mua' => $data['ngay_mua'] ?? $vattu->ngay_mua,
            'thoi_gian_bao_hanh' => $data['thoi_gian_bao_hanh'] ?? $vattu->thoi_gian_bao_hanh,
        ]);

        return ['success' => true, 'message' => 'Cap nhat vat tu thanh cong.'];
    }

    public function destroy(int $phongId, int $vattuId): array
    {
        $vattu = Vattu::where('phong_id', $phongId)->find($vattuId);
        if (! $vattu) {
            return ['success' => false, 'message' => 'Khong tim thay vat tu can xoa.'];
        }

        $vattu->delete();

        return ['success' => true, 'message' => 'Xoa vat tu thanh cong.'];
    }
}

