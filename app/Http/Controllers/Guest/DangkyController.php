<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\DangkyServiceInterface;
use App\Http\Requests\Guest\LuuDangkyRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**

 * Khu vực: Admin / Đăng ký cư trú
 
 * Vai trò: Điểm vào route Admin, nhận request, gọi DangkyService và trả về view/redirect.

 */

class DangkyController extends Controller
{
    public function __construct(
        private readonly DangkyServiceInterface $dangkyService
    ) {}

    public function create(Request $request): View|RedirectResponse
    {
        // Defensive validation - check if phong_id parameter exists
        $phongIdParam = $request->query('phong_id');
        if ($phongIdParam === null || !is_numeric($phongIdParam) || (int) $phongIdParam <= 0) {
            return redirect()->route('public.danhsachphong')
                ->with('toast_loai', 'error')
                ->with('toast_noidung', 'Vui lòng chọn phòng trước khi đăng ký.');
        }

        $phongId = (int) $phongIdParam;

        try {
            $duLieu = $this->dangkyService->layDuLieuFormDangKyKhach($phongId);
            
            if (($duLieu['success'] ?? false) === false) {
                return redirect()->route('public.danhsachphong')
                    ->with('toast_loai', 'error')
                    ->with('toast_noidung', $duLieu['toast_noidung'] ?? 'Không tìm thấy phòng.');
            }

            $viewDangKy = view()->exists('landing.phong.dangky') ? 'landing.phong.dangky' : 'landing.dangky';

            return view($viewDangKy, [
                'phong' => $duLieu['phong'],
            ]);
        } catch (\Throwable $e) {
            // Defensive error handling - catch any exceptions from service
            return redirect()->route('public.danhsachphong')
                ->with('toast_loai', 'error')
                ->with('toast_noidung', 'Đã xảy ra lỗi khi tải thông tin phòng. Vui lòng thử lại.');
        }
    }

    public function store(LuuDangkyRequest $request)
    {
        $dulieu = $request->validated();

        $result = $this->dangkyService->luuDangkyKhach($dulieu);

        return redirect()->back()->with([
            'toast_loai' => $result['toast_loai'],
            'toast_noidung' => $result['toast_noidung'],
        ]);
    }

    public function lookup(?string $token = null): View
    {
        $tokenTraCuu = $token ?: request()->query('token');
        $duLieu = $this->dangkyService->layDuLieuTraCuuKhach($tokenTraCuu);

        if (!empty($duLieu['error_message'])) {
            session()->flash('toast_loai', 'error');
            session()->flash('toast_noidung', $duLieu['error_message']);

            return view('landing.lookup', [
                'token' => $duLieu['token'] ?? $tokenTraCuu,
                'dangky' => null,
            ]);
        }

        return view('landing.lookup', [
            'token' => $duLieu['token'] ?? $tokenTraCuu,
            'dangky' => $duLieu['dangky'] ?? null,
        ]);
    }
}
