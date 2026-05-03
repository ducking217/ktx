<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ToaNha;
use App\Http\Requests\Admin\LuuToaNhaRequest;
use App\Http\Requests\Admin\CapNhatToaNhaRequest;
use Illuminate\Http\Request;

class ToaNhaController extends Controller
{
    public function index()
    {
        $danhSachToaNha = ToaNha::withCount('danhsachphong')->get();
        return view('admin.toanha.index', compact('danhSachToaNha'));
    }

    public function taoMoi()
    {
        return view('admin.toanha.form');
    }

    public function luu(LuuToaNhaRequest $request)
    {
        ToaNha::create($request->validated());

        return redirect()->route('admin.toanha.index')->with([
            'toast_loai' => 'thanhcong',
            'toast_noidung' => 'Khởi tạo tòa nhà thành công.',
        ]);
    }

    public function chiTiet(int $id)
    {
        $toaNha = ToaNha::findOrFail($id);
        return view('admin.toanha.form', compact('toaNha'));
    }

    public function capNhat(CapNhatToaNhaRequest $request, int $id)
    {
        $toaNha = ToaNha::findOrFail($id);
        $toaNha->update($request->validated());

        return redirect()->route('admin.toanha.index')->with([
            'toast_loai' => 'thanhcong',
            'toast_noidung' => 'Cập nhật tòa nhà thành công.',
        ]);
    }

    public function xoa(int $id)
    {
        $toaNha = ToaNha::withCount('danhsachphong')->findOrFail($id);

        if ($toaNha->danhsachphong_count > 0) {
            return redirect()->back()->with([
                'toast_loai' => 'loi',
                'toast_noidung' => 'Không thể xóa: Tòa nhà còn phòng đang hoạt động.',
            ]);
        }

        $toaNha->delete();

        return redirect()->route('admin.toanha.index')->with([
            'toast_loai' => 'thanhcong',
            'toast_noidung' => 'Đã xóa tòa nhà khỏi hệ thống.',
        ]);
    }
}
