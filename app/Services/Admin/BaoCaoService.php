<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Contracts\Admin\BaoCaoServiceInterface;
use App\Enums\ContractStatus;
use App\Enums\InvoiceStatus;
use App\Enums\BedStatus;
use App\Models\Hoadon;
use App\Models\Hopdong;
use App\Models\Phong;
use App\Models\Sinhvien;
use Illuminate\Support\Facades\DB;

class BaoCaoService implements BaoCaoServiceInterface
{
    public function layDuLieuTaiChinh(): array
    {
        // 1. Doanh thu 12 tháng gần nhất (dựa trên ngày thanh toán thực tế)
        $doanhThuTheoThang = Hoadon::selectRaw('MONTH(ngay_thanh_toan) as thang, YEAR(ngay_thanh_toan) as nam, SUM(tong_tien) as tong, COUNT(*) as so_luong')
            ->where('trang_thai', InvoiceStatus::Paid)
            ->whereNotNull('ngay_thanh_toan')
            ->where('ngay_thanh_toan', '>=', now()->subMonths(12))
            ->groupBy(DB::raw('YEAR(ngay_thanh_toan)'), DB::raw('MONTH(ngay_thanh_toan)'))
            ->orderBy(DB::raw('YEAR(ngay_thanh_toan)'))
            ->orderBy(DB::raw('MONTH(ngay_thanh_toan)'))
            ->get();

        // 2. Tổng cọc đang giữ (Hóa đơn LOAI_DEPOSIT đã thanh toán)
        $tongCocHienTai = (float) Hoadon::where('loai_hoadon', 'deposit')
            ->where('trang_thai', InvoiceStatus::Paid)
            ->sum('tong_tien');

        // 3. Số phòng đang thuê vs tổng phòng
        $tongPhong = Phong::count();
        $phongDangThue = Phong::whereHas('giuongs', function ($query) {
            $query->where('trang_thai', \App\Enums\BedStatus::Occupied);
        })->count();
        $tyLeLapDay = $tongPhong > 0 ? round(($phongDangThue / $tongPhong) * 100, 1) : 0;

        // 4. Top 5 phòng doanh thu cao nhất
        $topPhong = Hoadon::selectRaw('phong_id, SUM(tong_tien) as tong')
            ->where('trang_thai', InvoiceStatus::Paid)
            ->with('phong')
            ->groupBy('phong_id')
            ->orderByDesc('tong')
            ->limit(5)
            ->get();

        // 5. Tăng trưởng doanh thu tháng này so với tháng trước
        $thangNay = now()->month;
        $namNay = now()->year;
        $doanhThuThangNay = (float) Hoadon::where('trang_thai', InvoiceStatus::Paid)
            ->whereMonth('ngay_thanh_toan', $thangNay)
            ->whereYear('ngay_thanh_toan', $namNay)
            ->sum('tong_tien');

        $thangTruoc = now()->subMonth()->month;
        $namTruoc = now()->subMonth()->year;
        $doanhThuThangTruoc = (float) Hoadon::where('trang_thai', InvoiceStatus::Paid)
            ->whereMonth('ngay_thanh_toan', $thangTruoc)
            ->whereYear('ngay_thanh_toan', $namTruoc)
            ->sum('tong_tien');

        $tangTruong = 0;
        if ($doanhThuThangTruoc > 0) {
            $tangTruong = round((($doanhThuThangNay - $doanhThuThangTruoc) / $doanhThuThangTruoc) * 100, 1);
        }

        return [
            'doanhThuTheoThang' => $doanhThuTheoThang,
            'tongCocHienTai' => $tongCocHienTai,
            'tongPhong' => $tongPhong,
            'phongDangThue' => $phongDangThue,
            'tyLeLapDay' => $tyLeLapDay,
            'topPhong' => $topPhong,
            'doanhThuThangNay' => $doanhThuThangNay,
            'tangTruong' => $tangTruong,
        ];
    }

    public function layDuLieuExport(array $filters): array
    {
        $nam = $filters['nam'] ?? now()->year;
        $quy = $filters['quy'] ?? null;
        $thang = $filters['thang'] ?? null;

        $query = Hoadon::selectRaw('MONTH(ngay_thanh_toan) as thang, YEAR(ngay_thanh_toan) as nam, COUNT(*) as so_luong, SUM(tong_tien) as tong')
            ->where('trang_thai', InvoiceStatus::Paid->value)
            ->whereNotNull('ngay_thanh_toan')
            ->whereYear('ngay_thanh_toan', $nam);

        if ($thang) {
            $query->whereMonth('ngay_thanh_toan', $thang);
        }

        if ($quy) {
            $months = match ((int)$quy) {
                1 => [1, 2, 3],
                2 => [4, 5, 6],
                3 => [7, 8, 9],
                4 => [10, 11, 12],
                default => [],
            };
            if (!empty($months)) {
                $query->whereIn(DB::raw('MONTH(ngay_thanh_toan)'), $months);
            }
        }

        return $query->groupBy(DB::raw('YEAR(ngay_thanh_toan)'), DB::raw('MONTH(ngay_thanh_toan)'))
            ->orderBy(DB::raw('YEAR(ngay_thanh_toan)'))
            ->orderBy(DB::raw('MONTH(ngay_thanh_toan)'))
            ->get()
            ->map(function ($row) {
                return [
                    'thang' => $row->thang,
                    'nam' => $row->nam,
                    'so_luong' => $row->so_luong,
                    'tong' => $row->tong,
                    'trung_binh' => $row->so_luong > 0 ? round($row->tong / $row->so_luong, 2) : 0,
                ];
            })
            ->toArray();
    }
}
