<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Shared\TaiSanPhongServiceInterface;
use Illuminate\Http\Request;

class TaiSanController extends Controller
{
    public function __construct(
        private readonly TaiSanPhongServiceInterface $taiSanPhongService
    ) {}

    public function luu(Request $request, int $id)
    {
        $this->authorize('phong.manage');
        $duLieu = $request->validate([
            'tentaisan' => ['required', 'string', 'max:100'],
            'soluong' => ['required', 'integer', 'min:1'],
            'tinhtrang' => ['required', 'string', 'max:100'],
        ]);

        $result = $this->taiSanPhongService->store($duLieu, $id);

        return redirect()->back()->with([
            'toast_loai' => $result['success'] ? 'thanhcong' : 'loi',
            'toast_noidung' => $result['message'],
        ]);
    }

    public function capNhat(Request $request, int $id, int $taisanId)
    {
        $this->authorize('phong.manage');
        $duLieu = $request->validate([
            'tentaisan' => ['required', 'string', 'max:100'],
            'soluong' => ['required', 'integer', 'min:1'],
            'tinhtrang' => ['required', 'string', 'max:100'],
        ]);

        $result = $this->taiSanPhongService->update($duLieu, $id, $taisanId);

        return redirect()->back()->with([
            'toast_loai' => $result['success'] ? 'thanhcong' : 'loi',
            'toast_noidung' => $result['message'],
        ]);
    }

    public function xoa(int $id, int $taisanId)
    {
        $this->authorize('phong.manage');
        $result = $this->taiSanPhongService->destroy($id, $taisanId);

        return redirect()->back()->with([
            'toast_loai' => $result['success'] ? 'thanhcong' : 'loi',
            'toast_noidung' => $result['message'],
        ]);
    }
}
