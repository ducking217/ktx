<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Student\BaohongServiceInterface;
use App\Enums\MaintenanceStatus;
use Illuminate\Http\Request;

class BaohongController extends Controller
{
    public function __construct(
        private readonly BaohongServiceInterface $baohongService
    ) {}

    public function lietKeBaoHongAdmin(Request $request)
    {
        $data = $this->baohongService->listMaintenanceRequestsAdmin($request);
        return view('admin.baohong.danhsach', $data);
    }

    public function capNhatBaoHong(Request $request, int $id)
    {
        $this->authorize('baohong.manage');
        $dulieu = $request->validate([
            'trangthai' => ['required', 'in:' . implode(',', [
                MaintenanceStatus::Pending->value,
                MaintenanceStatus::Scheduled->value,
                MaintenanceStatus::InProgress->value,
                MaintenanceStatus::Completed->value,
            ])],
            'ngayhen' => ['nullable', 'date'],
            'noidung' => ['nullable', 'string'],
            'do_sinh_vien_gay_ra' => ['nullable', 'boolean'],
            'phi_boi_thuong' => ['nullable', 'numeric', 'min:0'],
        ]);

        $result = $this->baohongService->updateMaintenance($id, $dulieu);

        return redirect()->back()->with([
            'toast_loai' => $result['success'] ? 'thanhcong' : 'loi',
            'toast_noidung' => $result['message']
        ]);
    }
}
