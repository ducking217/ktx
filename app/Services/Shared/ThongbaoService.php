<?php

namespace App\Services\Shared;

use App\Contracts\Shared\ThongbaoServiceInterface;
use App\Models\Thongbao;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;

class ThongbaoService implements ThongbaoServiceInterface
{
    use PhanHoiService;

    public function indexForStudent(Request $yeuCau): array
    {
        $loai = $yeuCau->query('loai', 'tatca');

        $query = Thongbao::where(function ($truyVan) {
            $truyVan->where('doi_tuong_nhan', 'sinhvien')
                ->orWhere('doi_tuong_nhan', 'all')
                ->orWhereNull('doi_tuong_nhan');
        });

        if ($loai === 'moi_nhat') {
            $query->where('created_at', '>=', now()->subDays(7));
        }

        return [
            'thongbao' => $query->orderByDesc('created_at')->paginate(15),
            'loai' => $loai,
            'thongKe' => [
                'tong_so' => $query->count(),
                'trong_thang' => (clone $query)->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->count(),
                'tuan_nay' => (clone $query)->where('created_at', '>=', now()->subDays(7))->count(),
            ],
        ];
    }

    public function showForStudent(int $id): array
    {
        $query = Thongbao::where('id', $id)->where(function ($truyVan) {
            $truyVan->where('doi_tuong_nhan', 'sinhvien')
                ->orWhere('doi_tuong_nhan', 'all')
                ->orWhereNull('doi_tuong_nhan');
        });

        $thongbao = $query->first();
        if (! $thongbao) {
            return $this->traVeLoi('Khong tim thay thong bao.');
        }

        $thongbaoLienQuan = Thongbao::where('id', '<>', $id)
            ->where(function ($truyVan) {
                $truyVan->where('doi_tuong_nhan', 'sinhvien')
                    ->orWhere('doi_tuong_nhan', 'all')
                    ->orWhereNull('doi_tuong_nhan');
            })
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return [
            'thongbao' => $thongbao,
            'thongbaoLienQuan' => $thongbaoLienQuan,
        ];
    }

    public function indexForAdmin(): array
    {
        return [
            'thongbao' => Thongbao::orderByDesc('created_at')->paginate(20),
        ];
    }

    public function store(array $duLieu): array
    {
        try {
            $thongbao = new Thongbao();
            $thongbao->fill([
                'tieu_de' => $duLieu['tieu_de'],
                'noi_dung' => $duLieu['noi_dung'],
                'loai_thong_bao' => $duLieu['loai_thong_bao'] ?? 'general',
                'doi_tuong_nhan' => $duLieu['doi_tuong_nhan'] ?? 'all',
            ])->save();

            return $this->traVeThanhCong('Thao tac thanh cong.');
        } catch (\Throwable $throwable) {
            return $this->traVeLoi($throwable->getMessage());
        }
    }

    public function update(int $id, array $duLieu): array
    {
        try {
            $thongbao = Thongbao::find($id);
            if (! $thongbao) {
                return $this->traVeLoi('Khong tim thay thong bao.');
            }

            $thongbao->fill([
                'tieu_de' => $duLieu['tieu_de'],
                'noi_dung' => $duLieu['noi_dung'],
                'loai_thong_bao' => $duLieu['loai_thong_bao'] ?? 'general',
                'doi_tuong_nhan' => $duLieu['doi_tuong_nhan'] ?? 'all',
            ])->save();

            return $this->traVeThanhCong('Thao tac thanh cong.');
        } catch (\Throwable $throwable) {
            return $this->traVeLoi($throwable->getMessage());
        }
    }

    public function destroy(int $id): array
    {
        try {
            $thongbao = Thongbao::find($id);
            if (! $thongbao) {
                return $this->traVeLoi('Khong tim thay thong bao.');
            }

            $thongbao->delete();
            return $this->traVeThanhCong('Xoa thanh cong.');
        } catch (\Throwable $throwable) {
            return $this->traVeLoi($throwable->getMessage());
        }
    }
}

