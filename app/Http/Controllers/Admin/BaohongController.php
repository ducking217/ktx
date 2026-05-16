<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Student\BaohongServiceInterface;
use App\Enums\BaohongStatus;
use Illuminate\Http\Request;

/**

 * Khu vực: Admin / Báo hỏng
 
 * Vai trò: Quản lý danh sách báo hỏng và cập nhật trạng thái xử lý.

 */

class BaohongController extends Controller
{
    public function __construct(
        private readonly BaohongServiceInterface $baohongService
    ) {}

    public function lietKeBaoHongAdmin(Request $request)
    {
        $data = $this->baohongService->listMaintenanceRequestsAdmin($request);
        return view('admin.baohong.danhsach', $data);
    }

    public function capNhatBaoHong(Request $request, int $id)
    {
        $this->authorize('baohong.manage');
        $dulieu = $request->validate([
            'trang_thai' => ['required', 'in:' . implode(',', BaohongStatus::values())],
        ]);

        $result = $this->baohongService->updateMaintenance($id, [
            'trang_thai' => $dulieu['trang_thai'],
        ]);

        return redirect()->back()->with([
            'toast_loai' => $result['success'] ? 'thanhcong' : 'loi',
            'toast_noidung' => $result['message']
        ]);
    }
}
