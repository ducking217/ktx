<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Contracts\Core\TruyVanPhongServiceInterface;
use App\Contracts\Student\PhongSinhvienServiceInterface;
use Illuminate\Http\Request;

class PhongController extends Controller
{
    public function __construct(
        private readonly TruyVanPhongServiceInterface $truyVanPhongService,
        private readonly PhongSinhvienServiceInterface $roomService,
    ) {}

    /**
     * Danh sách phòng trống phù hợp giới tính cho sinh viên.
     */
    public function index(Request $request)
    {
        $data = $this->truyVanPhongService->lietKePhongChoSinhVien($request);
        if ($request->wantsJson()) {
            return response()->json([
                'data' => collect($data['danhsachphongtrong'])
                    ->values()
                    ->map(function ($phong) {
                        return [
                            'id' => $phong->id,
                            'ten_phong' => $phong->ten_phong,
                            'toa_nha' => $phong->toanha?->ten_toa_nha,
                            'tang' => $phong->tang,
                            'loai_phong' => $phong->loaiphong?->ten_loai,
                            'gia_thang' => (int) ($phong->loaiphong?->gia_thang ?? 0),
                            'suc_chua' => (int) ($phong->loaiphong?->suc_chua ?? 0),
                            'so_giuong_trong' => (int) ($phong->so_giuong_trong ?? 0),
                            'so_giuong_da_o' => (int) ($phong->so_giuong_da_o ?? 0),
                            'trang_thai' => $phong->trang_thai,
                            'gioi_tinh_han_che' => $phong->gioi_tinh_han_che?->value,
                            'so_tai_san_hong' => (int) ($phong->so_tai_san_hong ?? 0),
                        ];
                    }),
            ]);
        }

        return view('student.phong.danhsach', [
            'danhsachphong' => $data['danhsachphongtrong'],
            'danhsachphongsaptrong' => $data['danhsachphongsaptrong'] ?? collect(),
            'soluongdango_theophong' => $data['soluongdango_theophong'],
            'tuKhoa' => $data['tuKhoa'],
        ]);
    }
}
