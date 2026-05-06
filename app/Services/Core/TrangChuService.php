<?php

namespace App\Services\Core;

use App\Contracts\Core\TrangChuServiceInterface;
use App\Models\Cauhinh;
use App\Models\Lienhe;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\Thongbao;
use App\Models\ToaNha;
use Illuminate\Support\Facades\DB;

class TrangChuService implements TrangChuServiceInterface
{
    public function layDuLieuTrangChu(): array
    {
        $phongList = Phong::with('loaiphong')
            ->withCount(['giuongs as dango_count' => function ($query) {
                $query->where('trang_thai', \App\Enums\BedStatus::Occupied->value);
            }])
            ->get();
            
        $tongSucChua = (int) \App\Models\LoaiPhong::sum('suc_chua');
        $sinhVienDangO = (int) \App\Models\Giuong::where('trang_thai', \App\Enums\BedStatus::Occupied->value)->count();
        $soSinhVien = (int) Sinhvien::count();
        $soToa = (int) ToaNha::count();

        return [
            'tongSoPhong' => $phongList->count(),
            'tongCho' => $sinhVienDangO,
            'tongConTrong' => $tongSucChua - $sinhVienDangO,
            'phongHoanToanTrong' => Phong::whereDoesntHave('giuongs', function ($query) {
                $query->where('trang_thai', '!=', \App\Enums\BedStatus::Available->value);
            })->count(),
            'phongConCho' => Phong::whereHas('giuongs', function ($query) {
                $query->where('trang_thai', \App\Enums\BedStatus::Available->value);
            })->count(),
            'giaTrungBinh' => \App\Models\LoaiPhong::avg('gia_thang') ?? 1200000,
            'sinhVienDangO' => $sinhVienDangO,
            'soSinhVien' => $soSinhVien,
            'soToa' => $soToa,
            'phongList' => $phongList,
            'cauhinh' => Cauhinh::pluck('giatri', 'ten')->toArray(),
            'thongbao' => Thongbao::whereIn('doi_tuong_nhan', ['all', 'sinhvien'])
                ->orderByDesc('created_at')
                ->limit(3)
                ->get(),
        ];
    }

    public function guiLienHe(array $data): bool
    {
        DB::transaction(function () use ($data) {
            Lienhe::create([...$data, 'trang_thai' => Lienhe::TRANG_THAI_CHUA_XU_LY]);
            Thongbao::create([
                'tieu_de' => 'Liên hệ mới từ landing page',
                'noi_dung' => "Họ tên: {$data['ho_ten']} | Email: {$data['email']} | Nội dung: {$data['noi_dung']}",
                'doi_tuong_nhan' => 'admin',
            ]);
        });
        return true;
    }
}
