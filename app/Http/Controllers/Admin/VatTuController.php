<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Shared\VatTuPhongServiceInterface;
use Illuminate\Http\Request;

class VatTuController extends Controller
{
    public function __construct(
        private readonly VatTuPhongServiceInterface $vatTuPhongService
    ) {}

    public function luu(Request $request, int $id)
    {
        $this->authorize('phong.manage');
        $duLieu = $request->validate([
            'ten_vat_tu' => ['required', 'string', 'max:100'],
            'so_luong' => ['required', 'integer', 'min:1'],
            'tinh_trang' => ['required', 'string', 'max:100'],
            'mo_ta' => ['nullable', 'string', 'max:500'],
            'ngay_mua' => ['nullable', 'date'],
            'thoi_gian_bao_hanh' => ['nullable', 'string', 'max:100'],
        ]);

        $result = $this->vatTuPhongService->store($duLieu, $id);

        return redirect()->back()->with([
            'toast_loai' => $result['success'] ? 'thanhcong' : 'loi',
            'toast_noidung' => $result['message'],
        ]);
    }

    public function capNhat(Request $request, int $id, int $vattuId)
    {
        $this->authorize('phong.manage');
        $duLieu = $request->validate([
            'ten_vat_tu' => ['required', 'string', 'max:100'],
            'so_luong' => ['required', 'integer', 'min:1'],
            'tinh_trang' => ['required', 'string', 'max:100'],
            'mo_ta' => ['nullable', 'string', 'max:500'],
            'ngay_mua' => ['nullable', 'date'],
            'thoi_gian_bao_hanh' => ['nullable', 'string', 'max:100'],
        ]);

        $result = $this->vatTuPhongService->update($duLieu, $id, $vattuId);

        return redirect()->back()->with([
            'toast_loai' => $result['success'] ? 'thanhcong' : 'loi',
            'toast_noidung' => $result['message'],
        ]);
    }

    public function xoa(int $id, int $vattuId)
    {
        $this->authorize('phong.manage');
        $result = $this->vatTuPhongService->destroy($id, $vattuId);

        return redirect()->back()->with([
            'toast_loai' => $result['success'] ? 'thanhcong' : 'loi',
            'toast_noidung' => $result['message'],
        ]);
    }
}
