<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\HoadonServiceInterface;
use App\Contracts\Admin\TaiChinhServiceInterface;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class HoadonController extends Controller
{
    public function __construct(
        private readonly HoadonServiceInterface $hoadonService,
        private readonly TaiChinhServiceInterface $taiChinhService
    ) {}

    public function lietKeHoaDonAdmin(Request $request)
    {
        $data = $this->hoadonService->lietKeHoaDonAdmin($request);
        if (! $request->query->has('tab') && ! $request->query->has('trang_thai') && isset($data['activeTab'])) {
            return redirect()
                ->route('admin.hoadon.index', array_filter([
                    'tab' => $data['activeTab'],
                    'phong_id' => $request->query('phong_id'),
                ], fn ($v) => $v !== null && $v !== ''));
        }
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
            'hoa_don.*.phong_id' => ['required', 'numeric'],
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

    public function tuChoiXacNhanThanhToan(Request $request, int $id)
    {
        $duLieu = $request->validate([
            'ly_do' => ['nullable', 'string', 'max:255'],
        ]);

        $result = $this->hoadonService->tuChoiXacNhanThanhToan($id, $duLieu['ly_do'] ?? null);

        return redirect()->back()->with([
            'toast_loai' => $result['toast_loai'],
            'toast_noidung' => $result['toast_noidung'],
        ]);
    }

    public function nhacNoHoaDon(int $id)
    {
        $result = $this->taiChinhService->nhacNo($id);

        return redirect()->back()->with([
            'toast_loai' => $result['toast_loai'],
            'toast_noidung' => $result['toast_noidung'],
        ]);
    }

    public function downloadInvoicePDF(int $id)
    {
        $hoadon = \App\Models\Hoadon::with(['phong', 'hopdong.sinhvien.user', 'giao_dich_gan_nhat'])->find($id);
        if (! $hoadon || ! $hoadon->hopdong?->sinhvien) {
            abort(404, 'Không tìm thấy dữ liệu hóa đơn');
        }

        $pdf = Pdf::loadView('pdf.hoadon', [
            'hoadon' => $hoadon,
        ]);

        return $pdf->download("hoadon_{$hoadon->ma_hoa_don}.pdf");
    }

    public function giaoDienNhapHangLoat()
    {
        $data = $this->hoadonService->duLieuNhapHangLoat();
        return view('admin.hoadon.nhap-hang-loat', $data);
    }

    public function luuHangLoat(Request $request)
    {
        $dulieu = $request->validate([
            'thang' => ['required', 'numeric', 'min:1', 'max:12'],
            'nam' => ['required', 'numeric', 'min:2000', 'max:2100'],
            'hoa_don' => ['required', 'array'],
            'hoa_don.*.phong_id' => ['required', 'numeric'],
            'hoa_don.*.chisodiencu' => ['required', 'numeric', 'min:0'],
            'hoa_don.*.chisodienmoi' => ['required', 'numeric', 'min:0'],
            'hoa_don.*.chisonuoccu' => ['required', 'numeric', 'min:0'],
            'hoa_don.*.chisonuocmoi' => ['required', 'numeric', 'min:0'],
        ]);

        $result = $this->hoadonService->xuLyHoaDonHangLoat($dulieu);
        
        return redirect()->route('admin.hoadon.index')->with([
            'toast_loai' => $result['toast_loai'], 
            'toast_noidung' => $result['toast_noidung']
        ]);
    }
}
