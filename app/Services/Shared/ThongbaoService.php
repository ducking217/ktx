<?php

namespace App\Services\Shared;

use App\Contracts\Shared\ThongbaoServiceInterface;
use App\Models\Thongbao;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**

 * Khu vực: Shared / Thông báo
 
 * Vai trò: Gửi/ghi nhận thông báo và truy vấn danh sách thông báo theo đối tượng.

 */

class ThongbaoService implements ThongbaoServiceInterface
{
    use PhanHoiService;

    public function indexForStudent(Request $yeuCau): array
    {
        $loai = $yeuCau->query('loai', 'tatca');
        $nhom = $yeuCau->query('nhom', 'tatca');

        $baseQuery = Thongbao::where(function ($truyVan) {
            $truyVan->where('doi_tuong_nhan', Thongbao::TARGET_STUDENT)
                ->orWhere('doi_tuong_nhan', Thongbao::TARGET_ALL)
                ->orWhereNull('doi_tuong_nhan');
        });

        if ($loai === 'moi_nhat') {
            $baseQuery->where('created_at', '>=', now()->subDays(7));
        }

        if ($nhom !== 'tatca') {
            if (in_array($nhom, Thongbao::ALLOWED_TYPES, true)) {
                $baseQuery->where('loai_thong_bao', $nhom);
            }
        }

        $queryForList = (clone $baseQuery)->orderByDesc('created_at');
        $queryForStats = clone $baseQuery;

        return [
            'thongbao' => $queryForList->paginate(15),
            'loai' => $loai,
            'nhom' => $nhom,
            'thongKe' => [
                'tong_so' => (clone $queryForStats)->count(),
                'trong_thang' => (clone $queryForStats)->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->count(),
                'tuan_nay' => (clone $queryForStats)->where('created_at', '>=', now()->subDays(7))->count(),
            ],
        ];
    }

    public function showForStudent(int $id): array
    {
        $query = Thongbao::where('id', $id)->where(function ($truyVan) {
            $truyVan->where('doi_tuong_nhan', Thongbao::TARGET_STUDENT)
                ->orWhere('doi_tuong_nhan', Thongbao::TARGET_ALL)
                ->orWhereNull('doi_tuong_nhan');
        });

        $thongbao = $query->first();
        if (! $thongbao) {
            return $this->traVeLoi('Không tìm thấy thông báo.');
        }

        $thongbaoLienQuan = Thongbao::where('id', '<>', $id)
            ->where(function ($truyVan) {
                $truyVan->where('doi_tuong_nhan', Thongbao::TARGET_STUDENT)
                    ->orWhere('doi_tuong_nhan', Thongbao::TARGET_ALL)
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
                'loai_thong_bao' => $duLieu['loai_thong_bao'] ?? Thongbao::TYPE_GENERAL,
                'doi_tuong_nhan' => $duLieu['doi_tuong_nhan'] ?? Thongbao::TARGET_ALL,
            ])->save();

            return $this->traVeThanhCong('Thao tác thành công.');
        } catch (\Throwable $throwable) {
            Log::error('ThongbaoService.store failed', ['exception' => $throwable]);
            $message = config('app.debug') ? $throwable->getMessage() : 'Có lỗi xảy ra, vui lòng thử lại.';
            return $this->traVeLoi($message);
        }
    }

    public function update(int $id, array $duLieu): array
    {
        try {
            $thongbao = Thongbao::find($id);
            if (! $thongbao) {
                return $this->traVeLoi('Không tìm thấy thông báo.');
            }

            $thongbao->fill([
                'tieu_de' => $duLieu['tieu_de'],
                'noi_dung' => $duLieu['noi_dung'],
                'loai_thong_bao' => $duLieu['loai_thong_bao'] ?? Thongbao::TYPE_GENERAL,
                'doi_tuong_nhan' => $duLieu['doi_tuong_nhan'] ?? Thongbao::TARGET_ALL,
            ])->save();

            return $this->traVeThanhCong('Thao tác thành công.');
        } catch (\Throwable $throwable) {
            Log::error('ThongbaoService.update failed', ['thongbao_id' => $id, 'exception' => $throwable]);
            $message = config('app.debug') ? $throwable->getMessage() : 'Có lỗi xảy ra, vui lòng thử lại.';
            return $this->traVeLoi($message);
        }
    }

    public function destroy(int $id): array
    {
        try {
            $thongbao = Thongbao::find($id);
            if (! $thongbao) {
                return $this->traVeLoi('Không tìm thấy thông báo.');
            }

            $thongbao->delete();
            return $this->traVeThanhCong('Xóa thành công.');
        } catch (\Throwable $throwable) {
            Log::error('ThongbaoService.destroy failed', ['thongbao_id' => $id, 'exception' => $throwable]);
            $message = config('app.debug') ? $throwable->getMessage() : 'Có lỗi xảy ra, vui lòng thử lại.';
            return $this->traVeLoi($message);
        }
    }
}
