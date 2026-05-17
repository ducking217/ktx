<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Shared\ThongbaoServiceInterface;
use App\Models\Thongbao;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**

 * Khu vực: Admin / Thông báo
 
 * Vai trò: CRUD thông báo và điều phối hiển thị danh sách.

 */

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
            'loai_thong_bao' => ['nullable', Rule::in(Thongbao::ALLOWED_TYPES)],
            'doi_tuong_nhan' => ['nullable', Rule::in(Thongbao::ALLOWED_TARGETS)],
        ]);

        $ketQua = $this->thongbaoService->store($duLieu);
        return redirect()->back()->with(['toast_loai' => $ketQua['toast_loai'], 'toast_noidung' => $ketQua['toast_noidung']]);
    }

    public function update(Request $request, int $id)
    {
        $duLieu = $request->validate([
            'tieu_de' => ['required', 'string', 'max:255'],
            'noi_dung' => ['required', 'string'],
            'loai_thong_bao' => ['nullable', Rule::in(Thongbao::ALLOWED_TYPES)],
            'doi_tuong_nhan' => ['nullable', Rule::in(Thongbao::ALLOWED_TARGETS)],
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
