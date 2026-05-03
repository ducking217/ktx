<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Core\TruyVanPhongServiceInterface;
use App\Contracts\Shared\KhoPhongServiceInterface;
use App\Contracts\Shared\NghiepVuPhongServiceInterface;
use App\Http\Requests\Admin\LuuPhongRequest;
use App\Http\Requests\Admin\CapNhatPhongRequest;
use Illuminate\Http\Request;

class PhongController extends Controller
{
    public function __construct(
        private readonly TruyVanPhongServiceInterface $truyVanPhongService,
        private readonly NghiepVuPhongServiceInterface $nghiepVuPhongService,
        private readonly KhoPhongServiceInterface $khoPhongService,
    ) {}

    public function index(Request $request)
    {
        $data = $this->truyVanPhongService->lietKePhongChoAdmin($request);
        return view('admin.phong.danhsach', $data);
    }

    public function chiTiet(int $id)
    {
        $data = $this->truyVanPhongService->layChiTietPhong($id);
        if (isset($data['error'])) {
            return redirect()->route('admin.phong.index')->with([
                'toast_loai' => 'loi',
                'toast_noidung' => $data['error'],
            ]);
        }
        return view('admin.phong.chitiet', $data);
    }

    public function luu(LuuPhongRequest $request)
    {
        $this->authorize('phong.manage');
        $result = $this->nghiepVuPhongService->luuPhong($request->validated());
        return redirect()->back()->with(['toast_loai' => $result['success'] ? 'thanhcong' : 'loi', 'toast_noidung' => $result['message']]);
    }

    public function capNhat(CapNhatPhongRequest $request, int $id)
    {
        $this->authorize('phong.manage');
        $result = $this->nghiepVuPhongService->capNhatPhong($id, $request->validated());
        return redirect()->back()->with(['toast_loai' => $result['success'] ? 'thanhcong' : 'loi', 'toast_noidung' => $result['message']]);
    }

    public function xoa(int $id)
    {
        $this->authorize('phong.manage');
        $result = $this->nghiepVuPhongService->xoaPhong($id);
        return redirect()->back()->with(['toast_loai' => $result['success'] ? 'thanhcong' : 'loi', 'toast_noidung' => $result['message']]);
    }

    public function soDo(Request $request)
    {
        $data = $this->khoPhongService->layBanDoKyTucXa($request);
        return view('admin.phong.map', $data);
    }
}
