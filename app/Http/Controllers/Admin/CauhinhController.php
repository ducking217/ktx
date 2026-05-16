<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Core\TienIchServiceInterface;
use Illuminate\Http\Request;

/**

 * Khu vực: Class
 
 * Vai trò: Mô tả chức năng chính của lớp trong module tương ứng.

 */

class CauhinhController extends Controller
{
    public function __construct(
        private readonly TienIchServiceInterface $tienIchService
    ) {}

    public function index()
    {
        $cauhinh = $this->tienIchService->layCauHinh();
        return view('admin.cauhinh.index', compact('cauhinh'));
    }

    public function update(Request $request)
    {
        $this->tienIchService->capNhatCauHinh($request->except('_token'));

        return redirect()->back()->with([
            'toast_loai' => 'thanhcong',
            'toast_noidung' => 'Cập nhật cấu hình thành công.',
        ]);
    }
}
