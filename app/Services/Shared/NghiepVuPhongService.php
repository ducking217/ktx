<?php

namespace App\Services\Shared;

use App\Contracts\Shared\NghiepVuPhongServiceInterface;
use App\Models\Phong;
use App\Models\Hopdong;
use App\Traits\PhanHoiService;
use Illuminate\Support\Facades\Log;

/**

 * Khu vực: Shared / Nghiệp vụ phòng
 
 * Vai trò: Logic dùng chung liên quan điều phối phòng/giường phục vụ nhiều module.

 */

class NghiepVuPhongService implements NghiepVuPhongServiceInterface
{
    use PhanHoiService;

    public function luuPhong(array $data): array
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($data) {
            try {
                // 1. Tạo phòng
                $phong = Phong::create($data);

                // 2. Tự động tạo giường dựa trên sức chứa của Loại phòng
                $loaiPhong = $phong->loaiphong;
                if ($loaiPhong) {
                    for ($i = 1; $i <= $loaiPhong->suc_chua; $i++) {
                        $phong->giuongs()->create([
                            'ma_giuong' => $phong->ten_phong . '-G' . $i,
                            'trang_thai' => \App\Enums\BedStatus::Available,
                        ]);
                    }
                }

                return ['success' => true, 'message' => 'Thêm phòng và khởi tạo ' . ($loaiPhong->suc_chua ?? 0) . ' giường thành công.'];
            } catch (\Throwable $e) {
                Log::error("Store room failed: " . $e->getMessage());
                return ['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()];
            }
        });
    }

    public function capNhatPhong(int $id, array $data): array
    {
        try {
            $phong = Phong::find($id);
            if (!$phong) return ['success' => false, 'message' => 'Không tìm thấy phòng.'];

            $phong->update($data);
            return ['success' => true, 'message' => 'Cập nhật phòng thành công.'];
        } catch (\Throwable $e) {
            Log::error("Update room failed: " . $e->getMessage());
            return ['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()];
        }
    }

    public function xoaPhong(int $id): array
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($id) {
            try {
                $phong = Phong::with('giuongs')->lockForUpdate()->find($id);
                if (!$phong) return ['success' => false, 'message' => 'Không tìm thấy phòng.'];

                if ($blockMessage = $this->kiemTraRanhBuocXoa($phong)) {
                    return ['success' => false, 'message' => $blockMessage];
                }

                $phong->delete();
                return ['success' => true, 'message' => 'Xóa phòng thành công.'];
            } catch (\Throwable $e) {
                Log::error("Delete room failed: " . $e->getMessage());
                return ['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()];
            }
        });
    }

    private function kiemTraRanhBuocXoa(Phong $phong): ?string
    {
        // 1. Kiểm tra xem có giường nào đang có người ở không
        $hasOccupiedBed = $phong->giuongs()->where('trang_thai', \App\Enums\BedStatus::Occupied)->exists();
        if ($hasOccupiedBed) {
            return 'Phòng vẫn còn giường đang có sinh viên cư trú.';
        }

        // 2. Kiểm tra xem có hợp đồng nào đang hiệu lực không
        $hasActiveContract = \App\Models\Hopdong::where('phong_id', $phong->id)
            ->where('trang_thai', \App\Enums\ContractStatus::Active)
            ->exists();

        if ($hasActiveContract) {
            return 'Phòng còn hợp đồng cư trú đang hiệu lực.';
        }

        return null;
    }
}
