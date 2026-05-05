<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Student\KyluatServiceInterface;
use App\Enums\DisciplineLevel;
use Illuminate\Http\Request;

class KyluatController extends Controller
{
    public function __construct(
        private readonly KyluatServiceInterface $kyLuatService
    ) {}

    public function lietKeKyLuatAdmin(Request $request)
    {
        $data = $this->kyLuatService->listKyluatAdmin($request);
        return view('admin.kyluat.danhsach', [
            ...$data,
            'selectedSinhvien' => $request->query('sinhvien_id', ''),
            'selectedMucDo' => $request->query('muc_do', ''),
        ]);
    }

    public function lietKeKyLuatSinhVien()
    {
        $data = $this->kyLuatService->listKyluatStudent();
        return view('student.kyluatcuaem', $data);
    }

    public function storeDiscipline(Request $request)
    {
        $duLieu = $request->validate([
            'sinhvien_id' => \App\Rules\CommonRules::sinhvienId(),
            'tieu_de' => ['required', 'string', 'max:255'],
            'noi_dung' => ['required', 'string'],
            'ngay_vi_pham' => ['required', 'date'],
            'muc_do' => ['required', 'string', 'in:' . implode(',', DisciplineLevel::values())],
            'hinh_thuc_xu_ly' => ['nullable', 'string', 'max:255'],
        ]);

        $result = $this->kyLuatService->saveKyluat($duLieu);
        $type = $result['toast_loai'] ?? ($result['success'] ? 'thanhcong' : 'loi');
        return redirect()->back()->with(['toast_loai' => $type, 'toast_noidung' => $result['toast_noidung'] ?? $result['message']]);
    }

    public function updateDiscipline(Request $request, int $id)
    {
        $duLieu = $request->validate([
            'tieu_de' => ['required', 'string', 'max:255'],
            'noi_dung' => ['required', 'string'],
            'ngay_vi_pham' => ['required', 'date'],
            'muc_do' => ['required', 'string', 'in:' . implode(',', DisciplineLevel::values())],
            'hinh_thuc_xu_ly' => ['nullable', 'string', 'max:255'],
        ]);

        $result = $this->kyLuatService->saveKyluat($duLieu, $id);
        $type = $result['toast_loai'] ?? ($result['success'] ? 'thanhcong' : 'loi');
        return redirect()->back()->with(['toast_loai' => $type, 'toast_noidung' => $result['toast_noidung'] ?? $result['message']]);
    }

    public function destroyDiscipline(int $id)
    {
        $result = $this->kyLuatService->deleteKyluat($id);
        $type = $result['toast_loai'] ?? ($result['success'] ? 'thanhcong' : 'loi');
        return redirect()->back()->with(['toast_loai' => $type, 'toast_noidung' => $result['toast_noidung'] ?? $result['message']]);
    }
}
