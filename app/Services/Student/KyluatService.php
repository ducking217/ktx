<?php

namespace App\Services\Student;

use App\Contracts\Student\KyluatServiceInterface;
use App\Models\Kyluat;
use App\Models\Sinhvien;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**

 * Khu vực: Student / Kỷ luật
 
 * Vai trò: Truy vấn và hiển thị dữ liệu kỷ luật phục vụ sinh viên và/hoặc filter Admin.

 */

class KyluatService implements KyluatServiceInterface
{
    use PhanHoiService;

    public function listKyluatAdmin(Request $request): array
    {
        $tuKhoa = $request->query('q', '');
        $data = Kyluat::when($tuKhoa, function ($q) use ($tuKhoa) {
            $q->whereHas('sinhvien', fn($sq) => $sq->where('ma_sinh_vien', 'like', '%' . \App\Helpers\SecurityHelper::escapeLike($tuKhoa) . '%'));
        })->with(['sinhvien.user', 'sinhvien.current_hopdong.giuong.phong'])->orderByDesc('ngay_vi_pham')->paginate(20);

        $students = Cache::remember('admin.kyluat:students:v1', now()->addMinutes(10), function () {
            return Sinhvien::query()
                ->select(['id', 'user_id', 'ma_sinh_vien'])
                ->with('user:id,name')
                ->orderByDesc('id')
                ->get();
        });

        return ['kyluat' => $data, 'tuKhoa' => $tuKhoa, 'sinhviens' => $students];
    }

    public function listKyluatStudent(): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
        if (!$sinhvien) return ['kyluat' => collect()];
        return ['kyluat' => Kyluat::where('sinhvien_id', $sinhvien->id)->orderByDesc('ngay_vi_pham')->get()];
    }

    public function saveKyluat(array $data, ?int $id = null): array
    {
        try {
            $kyLuat = $id ? Kyluat::find($id) : new Kyluat();
            if ($id && !$kyLuat) return $this->traVeLoi('Không tìm thấy bản ghi.');

            $kyLuat->fill($data)->save();
            return $this->traVeThanhCong('Thao tác thành công.');
        } catch (\Throwable $e) {
            Log::error('KyluatService.saveKyluat failed', ['kyluat_id' => $id, 'exception' => $e]);
            $message = config('app.debug') ? $e->getMessage() : 'Có lỗi xảy ra, vui lòng thử lại.';
            return $this->traVeLoi($message);
        }
    }

    public function deleteKyluat(int $id): array
    {
        try {
            $kyLuat = Kyluat::find($id);
            if (!$kyLuat) return $this->traVeLoi('Không tìm thấy bản ghi.');
            $kyLuat->delete();
            return $this->traVeThanhCong('Xóa thành công.');
        } catch (\Throwable $e) {
            Log::error('KyluatService.deleteKyluat failed', ['kyluat_id' => $id, 'exception' => $e]);
            $message = config('app.debug') ? $e->getMessage() : 'Có lỗi xảy ra, vui lòng thử lại.';
            return $this->traVeLoi($message);
        }
    }
}
