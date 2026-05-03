<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Shared\GiaHanServiceInterface;
use Illuminate\Http\Request;

class GiaHanController extends Controller
{
    public function __construct(
        private readonly GiaHanServiceInterface $giaHanService
    ) {}

    public function index(Request $request)
    {
        $data = $this->giaHanService->lietKeYeuCauAdmin($request);
        return view('admin.giahan.danhsach', $data);
    }

    public function duyet(Request $request, int $id)
    {
        $dulieu = $request->validate([
            'ghi_chu_admin' => ['nullable', 'string', 'max:2000'],
        ]);

        $result = $this->giaHanService->duyetYeuCau($id, $dulieu['ghi_chu_admin'] ?? null);

        return redirect()->back()->with([
            'toast_loai' => $result['toast_loai'],
            'toast_noidung' => $result['toast_noidung'],
        ]);
    }

    public function tuChoi(Request $request, int $id)
    {
        $dulieu = $request->validate([
            'ghi_chu_admin' => ['nullable', 'string', 'max:2000'],
        ]);

        $result = $this->giaHanService->tuChoiYeuCau($id, $dulieu['ghi_chu_admin'] ?? null);

        return redirect()->back()->with([
            'toast_loai' => $result['toast_loai'],
            'toast_noidung' => $result['toast_noidung'],
        ]);
    }
}

