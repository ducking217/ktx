<?php

namespace App\Services\Admin;

use App\Contracts\Admin\BaoTriServiceInterface;
use App\Models\Lichsubaotri;
use App\Models\Phong;
use App\Models\Vattu;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**

 * Khu vực: Admin / Bảo trì
 
 * Vai trò: Quản lý lịch sử bảo trì, cập nhật trạng thái và xuất dữ liệu khi cần.

 */

class BaoTriService implements BaoTriServiceInterface
{
    use PhanHoiService;

    public function lietKeBaoTri(Request $request): array
    {
        $tuKhoa = $request->query('q', '');
        $data = Lichsubaotri::when($tuKhoa, function ($q) use ($tuKhoa) {
            $q->whereHas('phong', fn($pq) => $pq->where('ten_phong', 'like', '%' . \App\Helpers\SecurityHelper::escapeLike($tuKhoa) . '%'));
        })->with(['phong', 'vattu'])->orderByDesc('ngay_bao_tri')->paginate(20);

        return [
            'baotri' => $data,
            'tuKhoa' => $tuKhoa,
            'phongs' => Phong::all(),
            'vattus' => Vattu::all(),
        ];
    }

    public function luuBaoTri(array $data, ?int $id = null): array
    {
        try {
            $lichsu = $id ? Lichsubaotri::find($id) : new Lichsubaotri();
            if ($id && !$lichsu) return $this->traVeLoi('Không tìm thấy bản ghi.');

            $lichsu->fill($data)->save();
            return $this->traVeThanhCong('Thao tác thành công.');
        } catch (\Throwable $e) {
            Log::error('BaoTriService.luuBaoTri failed', ['lichsu_id' => $id, 'exception' => $e]);
            $message = config('app.debug') ? $e->getMessage() : 'Có lỗi xảy ra, vui lòng thử lại.';
            return $this->traVeLoi($message);
        }
    }

    public function xoaBaoTri(int $id): array
    {
        try {
            $lichsu = Lichsubaotri::find($id);
            if (!$lichsu) return $this->traVeLoi('Không tìm thấy bản ghi.');
            $lichsu->delete();
            return $this->traVeThanhCong('Xóa thành công.');
        } catch (\Throwable $e) {
            Log::error('BaoTriService.xoaBaoTri failed', ['lichsu_id' => $id, 'exception' => $e]);
            $message = config('app.debug') ? $e->getMessage() : 'Có lỗi xảy ra, vui lòng thử lại.';
            return $this->traVeLoi($message);
        }
    }

    public function hoanThanhBaoTri(int $id): array
    {
        try {
            $lichsu = Lichsubaotri::find($id);
            if (!$lichsu) return $this->traVeLoi('Không tìm thấy bản ghi.');
            $lichsu->update(['trang_thai' => Lichsubaotri::STATUS_DONE]);
            return $this->traVeThanhCong('Đã hoàn thành bảo trì.');
        } catch (\Throwable $e) {
            Log::error('BaoTriService.hoanThanhBaoTri failed', ['lichsu_id' => $id, 'exception' => $e]);
            $message = config('app.debug') ? $e->getMessage() : 'Có lỗi xảy ra, vui lòng thử lại.';
            return $this->traVeLoi($message);
        }
    }
}
