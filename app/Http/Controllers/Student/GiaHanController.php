<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Contracts\Shared\GiaHanServiceInterface;
use App\Models\Hopdong;
use App\Models\Sinhvien;
use App\Enums\ContractStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiaHanController extends Controller
{
    public function __construct(
        private readonly GiaHanServiceInterface $giaHanService
    ) {}

    public function index()
    {
        $data = $this->giaHanService->lietKeYeuCauSinhVien();
        if (isset($data['error'])) {
            return redirect()->route('student.trangchu')->with(['toast_loai' => 'loi', 'toast_noidung' => $data['error']]);
        }

        return view('student.giahan.danhsach', $data);
    }

    public function create()
    {
        $sinhvien = auth()->user()->sinhvien;
        if (! $sinhvien) {
            return redirect()->route('student.trangchu')->with(['toast_loai' => 'loi', 'toast_noidung' => 'Không tìm thấy thông tin sinh viên.']);
        }

        $hopdong = $this->giaHanService->layHopdongHieuLuc($sinhvien->id);

        if (! $hopdong) {
            return redirect()->route('student.hopdongcuatoi')->with(['toast_loai' => 'loi', 'toast_noidung' => 'Bạn chưa có hợp đồng hiệu lực để gia hạn.']);
        }

        return view('student.giahan.tao', [
            'hopdong' => $hopdong,
        ]);
    }

    public function store(Request $request)
    {
        $dulieu = $request->validate([
            'hopdong_id' => ['required', 'integer'],
            'ngay_ket_thuc_moi' => ['required', 'date', 'after:today'],
            'ly_do' => ['nullable', 'string', 'max:2000'],
        ]);

        $result = $this->giaHanService->guiYeuCau(
            (int) $dulieu['hopdong_id'],
            (string) $dulieu['ngay_ket_thuc_moi'],
            $dulieu['ly_do'] ?? null
        );

        return redirect()->route('student.giahan.index')->with([
            'toast_loai' => $result['toast_loai'],
            'toast_noidung' => $result['toast_noidung'],
        ]);
    }
}

