<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Shared\ThongbaoServiceInterface;
use Illuminate\Http\Request;

class ThongbaoController extends Controller
{
    public function __construct(
        private readonly ThongbaoServiceInterface $thongbaoService
    ) {}

    public function index()
    {
        $duLieuThongBao = $this->thongbaoService->indexForAdmin();
        return view('admin.thongbao.danhsach', $duLieuThongBao);
    }

    public function store(Request $request)
    {
        $duLieu = $request->validate([
            'tieu_de' => ['required', 'string', 'max:255'],
            'noi_dung' => ['required', 'string'],
            'loai_thong_bao' => ['nullable', 'in:general,emergency,maintenance,finance'],
            'doi_tuong_nhan' => ['nullable', 'in:all,guest,sinhvien,admin'],
        ]);

        $ketQua = $this->thongbaoService->store($duLieu);
        return redirect()->back()->with(['toast_loai' => $ketQua['toast_loai'], 'toast_noidung' => $ketQua['toast_noidung']]);
    }

    public function update(Request $request, int $id)
    {
        $duLieu = $request->validate([
            'tieu_de' => ['required', 'string', 'max:255'],
            'noi_dung' => ['required', 'string'],
            'loai_thong_bao' => ['nullable', 'in:general,emergency,maintenance,finance'],
            'doi_tuong_nhan' => ['nullable', 'in:all,guest,sinhvien,admin'],
        ]);

        $ketQua = $this->thongbaoService->update($id, $duLieu);
        return redirect()->back()->with(['toast_loai' => $ketQua['toast_loai'], 'toast_noidung' => $ketQua['toast_noidung']]);
    }

    public function destroy(int $id)
    {
        $ketQua = $this->thongbaoService->destroy($id);
        return redirect()->back()->with(['toast_loai' => $ketQua['toast_loai'], 'toast_noidung' => $ketQua['toast_noidung']]);
    }
}
