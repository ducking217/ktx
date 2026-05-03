<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\ToaNhaServiceInterface;
use App\Models\ToaNha;
use App\Http\Requests\Admin\LuuToaNhaRequest;
use App\Http\Requests\Admin\CapNhatToaNhaRequest;
use Exception;
use Illuminate\Http\Request;

class ToaNhaController extends Controller
{
    public function __construct(
        private readonly ToaNhaServiceInterface $toaNhaService
    ) {}

    public function index()
    {
        $danhSachToaNha = $this->toaNhaService->danhSach();
        return view('admin.toanha.index', compact('danhSachToaNha'));
    }

    public function taoMoi()
    {
        return view('admin.toanha.form');
    }

    public function luu(LuuToaNhaRequest $request)
    {
        $this->toaNhaService->luu($request->validated());

        return redirect()->route('admin.toanha.index')->with([
            'toast_loai' => 'thanhcong',
            'toast_noidung' => 'Khởi tạo tòa nhà thành công.',
        ]);
    }

    public function chiTiet(int $id)
    {
        $toaNha = $this->toaNhaService->timKiem($id);
        return view('admin.toanha.form', compact('toaNha'));
    }

    public function capNhat(CapNhatToaNhaRequest $request, int $id)
    {
        $toaNha = $this->toaNhaService->timKiem($id);
        $this->toaNhaService->capNhat($toaNha, $request->validated());

        return redirect()->route('admin.toanha.index')->with([
            'toast_loai' => 'thanhcong',
            'toast_noidung' => 'Cập nhật tòa nhà thành công.',
        ]);
    }

    public function xoa(int $id)
    {
        try {
            $toaNha = $this->toaNhaService->timKiem($id);
            $this->toaNhaService->xoa($toaNha);

            return redirect()->route('admin.toanha.index')->with([
                'toast_loai' => 'thanhcong',
                'toast_noidung' => 'Đã xóa tòa nhà khỏi hệ thống.',
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with([
                'toast_loai' => 'loi',
                'toast_noidung' => $e->getMessage(),
            ]);
        }
    }
}
