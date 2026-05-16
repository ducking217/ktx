<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Contracts\Admin\ToaNhaServiceInterface;
use App\Models\ToaNha;
use Exception;
use Illuminate\Database\Eloquent\Collection;

/**

 * Khu vực: Admin / Tòa nhà
 
 * Vai trò: CRUD tòa nhà và dữ liệu danh mục liên quan.

 */

class ToaNhaService implements ToaNhaServiceInterface
{
    public function __construct(
        private readonly \App\Contracts\Shared\NghiepVuPhongServiceInterface $nghiepVuPhongService
    ) {}

    /**
     * @inheritDoc
     */
    public function danhSach(): Collection
    {
        return ToaNha::withCount('phongs')
            ->withMax('phongs', 'tang')
            ->orderBy('ten_toa_nha')
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function timKiem(int $id): ToaNha
    {
        return ToaNha::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function luu(array $data): ToaNha
    {
        return ToaNha::create($data);
    }

    /**
     * @inheritDoc
     */
    public function capNhat(ToaNha $toaNha, array $data): ToaNha
    {
        $toaNha->update($data);
        return $toaNha;
    }

    /**
     * @inheritDoc
     */
    public function xoa(ToaNha $toaNha): void
    {
        // Thử xóa toàn bộ các phòng trống trong tòa nhà trước
        $phongs = $toaNha->phongs;
        foreach ($phongs as $phong) {
            $result = $this->nghiepVuPhongService->xoaPhong($phong->id);
            if (!($result['success'] ?? false)) {
                throw new Exception("Tòa nhà có phòng không thể xóa ({$phong->ten_phong}): " . $result['message']);
            }
        }

        // Vì Phòng sử dụng SoftDeletes, chúng ta phải xóa cứng (forceDelete) 
        // để không bị lỗi Foreign Key constraint khi xóa Tòa Nhà.
        $phongsWithTrashed = $toaNha->phongs()->withTrashed()->get();
        foreach ($phongsWithTrashed as $phong) {
            $phong->giuongs()->withTrashed()->forceDelete();
            $phong->forceDelete();
        }

        $toaNha->delete();
    }
}
