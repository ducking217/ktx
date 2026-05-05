<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\HopdongServiceInterface;
use App\Contracts\Shared\GiaHanServiceInterface;
use App\Models\Dangky;

class HopdongController extends Controller
{
    public function __construct(
        private readonly HopdongServiceInterface $hopdongService,
        private readonly GiaHanServiceInterface $giaHanService,
    ) {}

    public function index()
    {
        $duLieuHopDong = $this->hopdongService->lietKeHopDongSinhVien();
        $sinhvien = auth()->user()?->sinhvien;

        $duLieuGiaHan = $this->giaHanService->lietKeYeuCauSinhVien();
        $hopdongHieuLuc = $sinhvien ? $this->giaHanService->layHopdongHieuLuc((int) $sinhvien->id) : null;
        $yeuCauTraPhong = Dangky::query()
            ->where('user_id', auth()->id())
            ->where('ghi_chu', 'like', 'TRA_PHONG%')
            ->orderByDesc('id')
            ->first();

        return view('student.hopdong.index', array_merge(
            $duLieuHopDong,
            is_array($duLieuGiaHan) ? $duLieuGiaHan : [],
            ['hopdongHieuLuc' => $hopdongHieuLuc, 'yeuCauTraPhong' => $yeuCauTraPhong],
        ));
    }

    public function show(int $id)
    {
        $ketQua = $this->hopdongService->layChiTietHopDong($id);
        if (isset($ketQua['toast_loai']) && $ketQua['toast_loai'] === 'loi') {
            return redirect()->route('student.hopdongcuatoi')->with($ketQua);
        }

        $duLieuHopDong = $this->hopdongService->lietKeHopDongSinhVien();
        $sinhvien = auth()->user()?->sinhvien;
        $duLieuGiaHan = $this->giaHanService->lietKeYeuCauSinhVien();
        $hopdongHieuLuc = $sinhvien ? $this->giaHanService->layHopdongHieuLuc((int) $sinhvien->id) : null;
        $yeuCauTraPhong = Dangky::query()
            ->where('user_id', auth()->id())
            ->where('ghi_chu', 'like', 'TRA_PHONG%')
            ->orderByDesc('id')
            ->first();

        return view('student.hopdong.index', array_merge(
            $duLieuHopDong,
            is_array($duLieuGiaHan) ? $duLieuGiaHan : [],
            [
                'hopdongChiTiet' => $ketQua['hopdong'] ?? null,
                'hopdongHieuLuc' => $hopdongHieuLuc,
                'yeuCauTraPhong' => $yeuCauTraPhong,
            ],
        ));
    }
}
