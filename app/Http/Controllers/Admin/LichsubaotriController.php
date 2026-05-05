<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\BaoTriServiceInterface;
use Illuminate\Http\Request;

class LichsubaotriController extends Controller
{
    public function __construct(
        private readonly BaoTriServiceInterface $baoTriService
    ) {}

    public function index(Request $request)
    {
        $duLieuBaoTri = $this->baoTriService->lietKeBaoTri($request);
        return view('admin.baotri.danhsach', $duLieuBaoTri);
    }

    public function store(Request $request)
    {
        $dulieu = $request->validate([
            'phong_id' => ['nullable', 'exists:phong,id'],
            'vattu_id' => ['nullable', 'exists:vattu,id'],
            'ngay_bao_tri' => ['required', 'date'],
            'chi_phi' => ['nullable', 'numeric', 'min:0'],
            'noi_dung' => ['required', 'string'],
            'nguoi_thuc_hien' => ['required', 'string'],
            'trang_thai' => ['nullable', 'string'],
        ]);

        $ketQua = $this->baoTriService->luuBaoTri($dulieu);
        return redirect()->back()->with(['toast_loai' => $ketQua['toast_loai'], 'toast_noidung' => $ketQua['toast_noidung']]);
    }

    public function update(Request $request, int $id)
    {
        $dulieu = $request->validate([
            'phong_id' => ['nullable', 'exists:phong,id'],
            'vattu_id' => ['nullable', 'exists:vattu,id'],
            'ngay_bao_tri' => ['required', 'date'],
            'chi_phi' => ['nullable', 'numeric', 'min:0'],
            'noi_dung' => ['required', 'string'],
            'nguoi_thuc_hien' => ['required', 'string'],
            'trang_thai' => ['nullable', 'string'],
        ]);

        $ketQua = $this->baoTriService->luuBaoTri($dulieu, $id);
        return redirect()->back()->with(['toast_loai' => $ketQua['toast_loai'], 'toast_noidung' => $ketQua['toast_noidung']]);
    }

    public function hoanThanh(int $id)
    {
        $ketQua = $this->baoTriService->hoanThanhBaoTri($id);
        return redirect()->back()->with(['toast_loai' => $ketQua['toast_loai'], 'toast_noidung' => $ketQua['toast_noidung']]);
    }

    public function destroy(int $id)
    {
        $ketQua = $this->baoTriService->xoaBaoTri($id);
        return redirect()->back()->with(['toast_loai' => $ketQua['toast_loai'], 'toast_noidung' => $ketQua['toast_noidung']]);
    }
}
