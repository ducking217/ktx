<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\DangkyServiceInterface;
use App\Http\Requests\Admin\DuyetDangKyRequest;
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
     * Danh sách đơn đăng ký.
     */
    public function lietKeDangKyAdmin(Request $request)
    {
        $data = $this->dangkyService->lietKeDangKyAdmin($request);
        return view('admin.dangky.danhsach', $data);
    }

    /**
     * Duyệt đăng ký.
     */
    public function duyetDangKy(DuyetDangKyRequest $request, int $id)
    {
        $result = $this->dangkyService->duyetDangKy($id, $request->validated()['ngay_het_han'] ?? null);
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }

    /**
     * Từ chối đăng ký.
     */
    public function tuChoiDangKy(Request $request, int $id)
    {
        $result = $this->dangkyService->tuChoiDangKy($id, $request->input('ghichu'));
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }

    /**
     * Duyệt hồ sơ & yêu cầu thanh toán.
     */
    public function duyetHoSo(int $id)
    {
        $result = $this->dangkyService->duyetHoSo($id);
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }

    /**
     * Xác nhận thanh toán & kích hoạt tài khoản.
     */
    public function xacNhanThanhToan(int $id)
    {
        $result = $this->dangkyService->xacNhanThanhToan($id);
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }

    /**
     * Xử lý yêu cầu trả phòng.
     */
    public function xuLyTraPhong(Request $request, int $id)
    {
        $duLieu = $request->validate([
            'phi_hu_hai' => ['nullable', 'integer', 'min:0', 'max:2000000000'],
        ]);

        $result = $this->dangkyService->xuLyYeuCauTraPhong($id, isset($duLieu['phi_hu_hai']) ? (int) $duLieu['phi_hu_hai'] : null);
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }

    /**
     * Từ chối yêu cầu trả phòng.
     */
    public function tuChoiTraPhong(Request $request, int $id)
    {
        $result = $this->dangkyService->tuChoiYeuCauTraPhong($id, $request->input('ghichu'));
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }
}
