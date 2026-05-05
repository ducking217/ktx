<?php

namespace App\Repositories;

use App\Models\Phong;
use App\Contracts\Repositories\PhongRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PhongRepository implements PhongRepositoryInterface
{
    /**
     * Tìm phòng theo ID.
     */
    public function findById(int $id): ?Phong
    {
        return Phong::find($id);
    }

    /**
     * Lấy tất cả phòng, tùy chọn eager load.
     */
    public function all(array $with = []): Collection
    {
        return Phong::with($with)->get();
    }

    /**
     * Lấy danh sách phòng theo bộ lọc.
     *
     * @param array $filters ['q' => string, 'tang' => int|string, 'gioitinh' => string]
     * @param array $with Relations to eager load
     */
    public function filter(array $filters = [], array $with = []): Collection
    {
        return Phong::with($with)
            ->when($filters['q'] ?? null, function ($query, $q) {
                return $query->where('ten_phong', 'like', '%' . \App\Helpers\SecurityHelper::escapeLike(trim($q)) . '%');
            })
            ->when($filters['tang'] ?? null, function ($query, $tang) {
                return $query->where('tang', $tang);
            })
            ->when($filters['gioitinh'] ?? null, function ($query, $gioitinh) {
                return $query->where('gioi_tinh_han_che', $gioitinh);
            })
            ->orderBy('tang')
            ->orderBy('ten_phong')
            ->get();
    }

    /**
     * Tổng sức chứa của tất cả phòng.
     */
    public function tongSucChua(): int
    {
        return (int) \App\Models\LoaiPhong::sum('suc_chua');
    }

    /**
     * Tổng số sinh viên đang ở (Đếm số giường có trạng thái Occupied).
     */
    public function tongDangO(): int
    {
        return (int) \App\Models\Giuong::where('trang_thai', \App\Enums\BedStatus::Occupied->value)->count();
    }

    /**
     * Số phòng còn chỗ (Có ít nhất 1 giường Available).
     */
    public function demPhongConCho(): int
    {
        return Phong::whereHas('giuongs', function ($query) {
            $query->where('trang_thai', \App\Enums\BedStatus::Available->value);
        })->count();
    }

    /**
     * Số phòng hoàn toàn trống (Tất cả giường đều Available).
     */
    public function demPhongTrong(): int
    {
        // Một phòng trống nếu tất cả giường của nó đều available
        return Phong::whereDoesntHave('giuongs', function ($query) {
            $query->where('trang_thai', '!=', \App\Enums\BedStatus::Available->value);
        })->count();
    }
}

