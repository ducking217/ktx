<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\DangkyServiceInterface;
use App\Http\Requests\Student\LuuDangKyMoiRequest;
use App\Http\Requests\Student\YeuCauDoiPhongRequest;
use Illuminate\Http\Request;

/**

 * Khu vực: Admin / Đăng ký cư trú
 
 * Vai trò: Điểm vào route Admin, nhận request, gọi DangkyService và trả về view/redirect.

 */

class DangkyController extends Controller
{
    public function __construct(
        private readonly DangkyServiceInterface $dangkyService
    ) {}

    /**
     * Gửi đăng ký phòng mới.
     */
    public function luuDangKySinhVien(LuuDangKyMoiRequest $request)
    {
        $result = $this->dangkyService->luuDangKySinhVien($request->validated());
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }

    /**
     * Gửi yêu cầu trả phòng.
     */
    public function yeuCauTraPhong(Request $request)
    {
        $data = $request->validate([
            'ly_do' => ['required', 'string', 'min:10', 'max:500'],
        ], [
            'ly_do.required' => 'Vui lòng nhập lý do trả phòng.',
            'ly_do.min' => 'Lý do trả phòng phải có ít nhất 10 ký tự.',
            'ly_do.max' => 'Lý do trả phòng không được vượt quá 500 ký tự.',
        ]);

        $result = $this->dangkyService->yeuCauTraPhong($data['ly_do']);
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }

    /**
     * Gửi yêu cầu đổi phòng.
     */
    public function yeuCauDoiPhong(YeuCauDoiPhongRequest $request)
    {
        $result = $this->dangkyService->yeuCauDoiPhong($request->validated());
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }
}
