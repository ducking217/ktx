<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\HoadonServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**

 * Khu vực: Admin / Hóa đơn
 
 * Vai trò: Điều phối thao tác hóa đơn (tạo tháng, nhập hàng loạt, xác nhận/từ chối, xuất PDF).

 */

class HoadonController extends Controller
{
    public function __construct(
        private readonly HoadonServiceInterface $hoadonService
    ) {}

    public function layHoaDonSinhVien()
    {
        $data = $this->hoadonService->layHoaDonSinhVien();
        if (isset($data['error'])) {
            return redirect()->back()->with(['toast_loai' => 'loi', 'toast_noidung' => $data['error']]);
        }
        if (! request()->query->has('tab') && isset($data['activeTab'])) {
            return redirect()->to(request()->fullUrlWithQuery([
                'tab' => $data['activeTab'],
                'page' => null,
            ]));
        }
        return view('student.phongcuatoi.lichSuHoaDon', $data);
    }

    public function layChiTietHoaDonSinhVien(int $id)
    {
        $data = $this->hoadonService->layChiTietHoaDonSinhVien($id);
        if (isset($data['error'])) {
            return redirect()->back()->with(['toast_loai' => 'loi', 'toast_noidung' => $data['error']]);
        }
        Log::info('student_invoice_detail_viewed', [
            'user_id' => auth()->id(),
            'hoadon_id' => $id,
            'trang_thai' => $data['hoadon']?->trang_thai?->value ?? null,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        return view('student.phongcuatoi.chiTietHoaDon', $data);
    }

    public function xacNhanViPham(int $id)
    {
        $result = $this->hoadonService->xacNhanViPham($id);
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }

    public function yeuCauXacNhanThanhToan(Request $request, int $id)
    {
        $validated = $request->validate([
            'ma_giao_dich' => ['nullable', 'string', 'max:120'],
            'ghi_chu' => ['nullable', 'string', 'max:500'],
        ]);

        $result = $this->hoadonService->yeuCauXacNhanThanhToanSinhVien($id, $validated);
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }
}
