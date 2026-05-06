<?php

namespace App\Services\Student;

use App\Contracts\Student\PhongSinhvienServiceInterface;
use App\Models\Danhgia;
use App\Models\Dangky;
use App\Models\Hoadon;
use App\Models\Hopdong;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\Taisan;
use App\Models\Thongbao;
use App\Models\Vattu;
use App\Enums\RegistrationStatus;
use Illuminate\Support\Facades\Auth;

class PhongSinhvienService implements PhongSinhvienServiceInterface
{
    public function layThongTinPhongToi(): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->with(['user', 'current_hopdong.giuong.phong.loaiphong'])->first();
        if (!$sinhvien) return ['error' => 'Không tìm thấy thông tin sinh viên.'];

        $hopdong = $sinhvien->current_hopdong;
        if (!$hopdong || !$hopdong->giuong?->phong_id) {
            $dangkyPhongGanNhat = Dangky::with(['phong.toanha', 'phong.loaiphong', 'toanha', 'loaiphong'])
                ->where('user_id', $sinhvien->user_id)
                ->where(function ($q) {
                    $q->whereNull('ghi_chu')
                        ->orWhere('ghi_chu', 'not like', 'TRA_PHONG%');
                })
                ->orderByDesc('id')
                ->first();

            return [
                'sinhvien' => $sinhvien,
                'coPhong' => false,
                'daGuiYeuCauTraPhong' => false,
                'dangkyPhongGanNhat' => $dangkyPhongGanNhat,
                'danhsachphongtrong' => $this->layDanhSachPhongPhuHop($sinhvien),
            ];
        }

        $phongId = $hopdong->giuong->phong_id;
        $phong = Phong::with(['taisans', 'vattus', 'loaiphong'])->find($phongId);
        
        // Bạn cùng phòng: những sinh viên có hợp đồng active trong cùng phòng
        $banCungPhong = Sinhvien::whereHas('hopdongs', function ($q) use ($phongId) {
            $q->where('trang_thai', \App\Enums\ContractStatus::Active->value)
              ->whereHas('giuong', fn($g) => $g->where('phong_id', $phongId));
        })->where('id', '<>', $sinhvien->id)->with('user')->get();

        $hoadon = Hoadon::where('hopdong_id', $hopdong->id)
            ->where('trang_thai', \App\Enums\InvoiceStatus::Unpaid->value)
            ->orderByDesc('created_at')
            ->get();

        $daGuiYeuCauTraPhong = Dangky::where('user_id', $sinhvien->user_id)
            ->where('trang_thai', RegistrationStatus::Pending)
            ->where('ghi_chu', 'like', 'TRA_PHONG%')
            ->exists();

        return [
            'sinhvien' => $sinhvien, 
            'coPhong' => true, 
            'phong' => $phong, 
            'banCungPhong' => $banCungPhong,
            'hopdongHienTai' => $hopdong, 
            'hoadonChuaThanhToan' => $hoadon, 
            'tongNo' => $hoadon->sum('tong_tien'),
            'taisan' => $phong->taisans,
            'vattu' => $phong->vattus ?? collect(),
            'daGuiYeuCauTraPhong' => $daGuiYeuCauTraPhong,
            'daDanhGia' => Danhgia::where('sinhvien_id', $sinhvien->id)
                ->where('phong_id', $phongId)
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->exists(),
            'diemTrungBinh' => round(Danhgia::where('phong_id', $phongId)->avg('rating') ?? 0, 1),
            'thongbaoMoiNhat' => Thongbao::whereIn('doi_tuong_nhan', ['all', 'sinhvien'])->orderByDesc('created_at')->limit(5)->get(),
            'canhBaoHetHan' => $this->layCanhBaoHetHan($hopdong),
        ];
    }

    private function layCanhBaoHetHan($hopdong)
    {
        if (!$hopdong || !$hopdong->ngay_ket_thuc) return null;
        $diff = now()->diffInDays(\Illuminate\Support\Carbon::parse($hopdong->ngay_ket_thuc), false);
        if ($diff > 30 || $diff < 0) return null;
        return [
            'so_ngay_con_lai' => $diff,
            'ngay_het_han' => \Illuminate\Support\Carbon::parse($hopdong->ngay_ket_thuc)->format('d/m/Y'),
            'muc_do' => $diff <= 7 ? 'nguy_hiểm' : ($diff <= 15 ? 'cảnh_báo' : 'thông_báo'),
        ];
    }

    private function layDanhSachPhongPhuHop($sinhvien)
    {
        $gioitinh = $sinhvien->user->gender ?? null;
        return Phong::when($gioitinh, fn($q) => $q->where('gioi_tinh_han_che', $gioitinh))
            ->with([
                'loaiphong',
                'toanha',
                'taisans:id,phong_id,ten_tai_san,so_luong',
                'vattus:id,phong_id,ten_vat_tu,so_luong',
            ])
            ->withCount(['giuongs as so_nguoi_dang_o' => function ($query) {
                $query->where('trang_thai', \App\Enums\BedStatus::Occupied);
            }])
            ->get()
            ->filter(fn($p) => $p->so_nguoi_dang_o < (int)($p->loaiphong->suc_chua ?? 0))
            ->take(5);
    }
}
