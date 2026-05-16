<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Shared\SinhvienServiceInterface;
use App\Models\Sinhvien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**

 * Khu vực: Admin / Sinh viên
 
 * Vai trò: Danh sách/chi tiết sinh viên, cập nhật hồ sơ, và thao tác chuyển phòng.

 */

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
        $sinhvien = Sinhvien::with('user')->find($id);
        if (!$sinhvien || !$sinhvien->user) {
            return redirect()->back()->with(['toast_loai' => 'loi', 'toast_noidung' => 'Không tìm thấy hồ sơ sinh viên.']);
        }
        $dulieu = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($sinhvien->user->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'dob' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'max:500'],
            'id_card' => ['nullable', 'string', 'max:30'],
            'ma_sinh_vien' => [
                'required',
                'string',
                'max:20',
                Rule::unique('sinhvien', 'ma_sinh_vien')->ignore($id),
            ],
            'lop' => ['nullable', 'string', 'max:50'],
            'khoa' => ['nullable', 'string', 'max:100'],
            'ngay_nhap_hoc' => ['nullable', 'date'],
            'anh_the' => ['nullable', 'image', 'max:4096'],
            'anh_cccd' => ['nullable', 'image', 'max:4096'],
        ]);

        $dulieu['anh_the'] = $request->file('anh_the');
        $dulieu['anh_cccd'] = $request->file('anh_cccd');

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
