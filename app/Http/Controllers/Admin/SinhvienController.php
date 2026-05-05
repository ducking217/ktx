<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Shared\SinhvienServiceInterface;
use Illuminate\Http\Request;

class SinhvienController extends Controller
{
    public function __construct(
        private readonly SinhvienServiceInterface $sinhvienService
    ) {}

    public function lietKeSinhVien(Request $request)
    {
        $data = $this->sinhvienService->listStudents($request);
        return view('admin.sinhvien.danhsach', $data);
    }

    public function chiTiet(int $id)
    {
        $data = $this->sinhvienService->getStudentProfile($id);
        if (isset($data['error'])) {
            return redirect()->back()->with(['toast_loai' => 'loi', 'toast_noidung' => $data['error']]);
        }
        return view('admin.sinhvien.chitiet', $data);
    }

    public function capNhatSinhVien(Request $request, int $id)
    {
        $this->authorize('sinhvien.manage');
        $dulieu = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ma_sinh_vien' => ['required', 'string', 'max:20'],
            'lop' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'string', 'max:20'], // PII encryption will handle this in service if needed
            'gender' => ['required', 'in:male,female,other'],
        ]);

        $result = $this->sinhvienService->updateStudent($id, $dulieu);
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }

    public function chuyenPhong(Request $request, int $id)
    {
        $this->authorize('sinhvien.manage');
        $dulieu = $request->validate(['phong_id' => ['nullable', 'numeric']]);
        $result = $this->sinhvienService->assignRoom($id, $dulieu['phong_id'] ?? null);
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }

    public function choRoiOPhong(int $id)
    {
        $this->authorize('sinhvien.manage');
        $result = $this->sinhvienService->removeFromRoom($id);
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }
}
