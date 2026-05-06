<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\HopdongServiceInterface;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class HopdongController extends Controller
{
    public function __construct(
        private readonly HopdongServiceInterface $hopdongService
    ) {}

    public function index(Request $request)
    {
        $duLieuHopDong = $this->hopdongService->lietKeHopDongAdmin($request);
        return view('admin.hopdong.danhsach', $duLieuHopDong);
    }

    public function store(Request $request)
    {
        $duLieu = $request->validate([
            'sinhvien_id' => ['required', 'integer', 'exists:sinhvien,id'],
            'phong_id' => ['nullable', 'integer', 'exists:phong,id'],
            'giuong_id' => ['nullable', 'integer', 'exists:giuong,id'],
            'ngay_bat_dau' => ['required', 'date'],
            'ngay_ket_thuc' => ['required', 'date', 'after:ngay_bat_dau'],
        ], [
            'phong_id.required_without' => 'Phải chọn phòng hoặc giường',
            'giuong_id.required_without' => 'Phải chọn giường hoặc phòng',
        ]);

        // Validate: Phải cung cấp ít nhất một trong hai: phong_id hoặc giuong_id
        if (!$request->has('phong_id') && !$request->has('giuong_id')) {
            return redirect()->back()
                ->withErrors(['phong_id' => 'Phải chọn phòng hoặc giường để tạo hợp đồng'])
                ->withInput();
        }

        $ketQua = $this->hopdongService->taoHopDong($duLieu);

        if (isset($ketQua['toast_loai'], $ketQua['toast_noidung'])) {
            return redirect()->back()->with([
                'toast_loai' => $ketQua['toast_loai'],
                'toast_noidung' => $ketQua['toast_noidung'],
            ]);
        }

        return redirect()->back()->with([
            'toast_loai' => ($ketQua['success'] ?? false) ? 'thanhcong' : 'loi',
            'toast_noidung' => $ketQua['message'] ?? 'Khong the tao hop dong.',
        ]);
    }

    public function show(int $id)
    {
        $ketQua = $this->hopdongService->layChiTietHopDong($id);
        if (isset($ketQua['toast_loai']) && $ketQua['toast_loai'] === 'loi') {
            return redirect()->route('admin.hopdong.index')->with($ketQua);
        }

        $danhSach = $this->hopdongService->lietKeHopDongAdmin(request());
        return view('admin.hopdong.danhsach', array_merge($danhSach, ['hopdongChiTiet' => $ketQua['hopdong'] ?? null]));
    }

    public function extend(Request $request, int $id)
    {
        $dulieu = $request->validate([
            'ngay_ket_thuc_moi' => ['nullable', 'date', 'after:today'],
            'ngay_ket_thuc' => ['nullable', 'date', 'after:today'],
            'ngay_ket_thuc_cu' => ['nullable', 'date'],
        ]);

        $ngayMoi = $dulieu['ngay_ket_thuc_moi'] ?? $dulieu['ngay_ket_thuc'] ?? null;
        $ngayCu = $dulieu['ngay_ket_thuc_cu'] ?? optional($this->hopdongService->layChiTietHopDong($id)['hopdong'] ?? null)->ngay_ket_thuc;

        if (! $ngayMoi || ! $ngayCu) {
            return redirect()->back()->with(['toast_loai' => 'loi', 'toast_noidung' => 'Thieu du lieu gia han hop dong.']);
        }

        $ketQua = $this->hopdongService->giaHanHopDong($id, $ngayMoi, $ngayCu);
        if (isset($ketQua['toast_loai'], $ketQua['toast_noidung'])) {
            return redirect()->back()->with([
                'toast_loai' => $ketQua['toast_loai'],
                'toast_noidung' => $ketQua['toast_noidung'],
            ]);
        }

        $loai = ($ketQua['success'] ?? false) ? 'thanhcong' : 'loi';
        return redirect()->back()->with(['toast_loai' => $loai, 'toast_noidung' => $ketQua['message'] ?? 'Khong the gia han hop dong.']);
    }

    public function destroy(Request $request, int $id)
    {
        $dulieu = $request->validate([
            'phi_hu_hai' => ['nullable', 'numeric', 'min:0'],
        ]);
        
        $phiHuHai = (int) ($dulieu['phi_hu_hai'] ?? 0);

        $ketQua = $this->hopdongService->thanhLyHopDong($id, $phiHuHai);
        if (isset($ketQua['toast_loai'], $ketQua['toast_noidung'])) {
            return redirect()->back()->with([
                'toast_loai' => $ketQua['toast_loai'],
                'toast_noidung' => $ketQua['toast_noidung'],
            ]);
        }

        $loai = ($ketQua['success'] ?? false) ? 'thanhcong' : 'loi';
        return redirect()->back()->with(['toast_loai' => $loai, 'toast_noidung' => $ketQua['message'] ?? 'Khong the thanh ly hop dong.']);
    }

    public function downloadPDF(int $id)
    {
        $hopdong = \App\Models\Hopdong::with(['sinhvien.user', 'giuong.phong.loaiphong'])->find($id);
        if (!$hopdong || !$hopdong->sinhvien) {
            abort(404, 'Không tìm thấy dữ liệu hợp đồng');
        }

        $pdf = Pdf::loadView('pdf.hopdong', [
            'hopdong' => $hopdong,
        ]);

        return $pdf->download('hopdong_' . ($hopdong->ma_hd ?? "HD-{$hopdong->id}") . '.pdf');
    }
}
