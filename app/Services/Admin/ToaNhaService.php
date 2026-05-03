<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Contracts\Admin\ToaNhaServiceInterface;
use App\Models\ToaNha;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ToaNhaService implements ToaNhaServiceInterface
{
    /**
     * @inheritDoc
     */
    public function danhSach(): Collection
    {
        return ToaNha::withCount('danhsachphong')
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
        // Kiểm tra số lượng phòng trước khi xóa
        if ($toaNha->danhsachphong()->count() > 0) {
            throw new Exception('Không thể xóa: Tòa nhà còn phòng đang hoạt động');
        }

        $toaNha->delete();
    }
}
