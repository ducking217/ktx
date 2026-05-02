<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\HoadonServiceInterface;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class HoadonController extends Controller
{
    public function __construct(
        private readonly HoadonServiceInterface $hoadonService
    ) {}

    public function lietKeHoaDonAdmin(Request $request)
    {
        $data = $this->hoadonService->lietKeHoaDonAdmin($request);
        return view('admin.hoadon.danhsach', $data);
    }

    public function xuLyHoaDon(Request $request)
    {
        $dulieu = $request->validate([
            'phong_id' => ['required', 'numeric'],
            'thang' => ['required', 'numeric', 'min:1', 'max:12'],
            'nam' => ['required', 'numeric', 'min:2000', 'max:2100'],
            'chisodiencu' => ['required', 'numeric', 'min:0'],
            'chisodienmoi' => ['required', 'numeric', 'min:0'],
            'chisonuoccu' => ['required', 'numeric', 'min:0'],
            'chisonuocmoi' => ['required', 'numeric', 'min:0'],
        ]);

        $result = $this->hoadonService->xuLyHoaDon($dulieu);
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }

    public function nhapHangLoat(Request $request)
    {
        $dulieu = $request->validate([
            'thang' => ['required', 'numeric', 'min:1', 'max:12'],
            'nam' => ['required', 'numeric', 'min:2000', 'max:2100'],
            'hoa_don' => ['required', 'array'],
            'hoa_don.*.chisodiencu' => ['nullable', 'numeric', 'min:0'],
            'hoa_don.*.chisodienmoi' => ['required', 'numeric', 'min:0'],
            'hoa_don.*.chisonuoccu' => ['nullable', 'numeric', 'min:0'],
            'hoa_don.*.chisonuocmoi' => ['required', 'numeric', 'min:0'],
        ]);

        $result = $this->hoadonService->xuLyHoaDonHangLoat($dulieu);
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }

    public function xacNhanThanhToan(int $id)
    {
        $result = $this->hoadonService->xacNhanThanhToan($id);
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }

    public function downloadInvoicePDF(int $id)
    {
        $hoadon = \App\Models\Hoadon::with(['phong', 'sinhvien.taikhoan'])->find($id);
        if (!$hoadon) {
            return redirect()->back()->with(['toast_loai' => 'loi', 'toast_noidung' => 'Không tìm thấy hóa đơn.']);
        }

        $pdf = Pdf::loadView('pdf.hoadon', [
            'hoadon' => $hoadon,
            'dongiadien' => $this->hoadonService->layBangGia()['dongiadien'],
            'dongianuoc' => $this->hoadonService->layBangGia()['dongianuoc'],
        ]);

        return $pdf->download("hoadon_{$hoadon->id}_{$hoadon->thang}_{$hoadon->nam}.pdf");
    }
}
