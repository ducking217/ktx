<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Contracts\Admin\BaoCaoServiceInterface;
use App\Enums\ContractStatus;
use App\Enums\InvoiceStatus;
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
        $doanhThuTheoThang = Hoadon::selectRaw('MONTH(ngay_thanh_toan) as thang, YEAR(ngay_thanh_toan) as nam, SUM(tongtien) as tong, COUNT(*) as so_luong')
            ->where('trangthaithanhtoan', InvoiceStatus::Paid->value)
            ->whereNotNull('ngay_thanh_toan')
            ->where('ngay_thanh_toan', '>=', now()->subMonths(12))
            ->groupBy('nam', 'thang')
            ->orderBy('nam')
            ->orderBy('thang')
            ->get();

        // 2. Tổng cọc đang giữ (Hóa đơn LOAI_DEPOSIT đã thanh toán)
        $tongCocHienTai = (float) Hoadon::where('loai_hoadon', 'deposit')
            ->where('trangthaithanhtoan', InvoiceStatus::Paid->value)
            ->sum('tongtien');

        // 3. Số phòng đang thuê vs tổng phòng
        $tongPhong = Phong::count();
        $phongDangThue = Phong::where('dango', '>', 0)->count();
        $tyLeLapDay = $tongPhong > 0 ? round(($phongDangThue / $tongPhong) * 100, 1) : 0;

        // 4. Top 5 phòng doanh thu cao nhất
        $topPhong = Hoadon::with('phong')
            ->selectRaw('phong_id, SUM(tongtien) as tong')
            ->where('trangthaithanhtoan', InvoiceStatus::Paid->value)
            ->groupBy('phong_id')
            ->orderByDesc('tong')
            ->limit(5)
            ->get();

        // 5. Tăng trưởng doanh thu tháng này so với tháng trước
        $thangNay = now()->month;
        $namNay = now()->year;
        $doanhThuThangNay = (float) Hoadon::where('trangthaithanhtoan', InvoiceStatus::Paid->value)
            ->where('thang', $thangNay)
            ->where('nam', $namNay)
            ->sum('tongtien');

        $thangTruoc = now()->subMonth()->month;
        $namTruoc = now()->subMonth()->year;
        $doanhThuThangTruoc = (float) Hoadon::where('trangthaithanhtoan', InvoiceStatus::Paid->value)
            ->where('thang', $thangTruoc)
            ->where('nam', $namTruoc)
            ->sum('tongtien');

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

        $query = Hoadon::selectRaw('MONTH(ngay_thanh_toan) as thang, YEAR(ngay_thanh_toan) as nam, COUNT(*) as so_luong, SUM(tongtien) as tong')
            ->where('trangthaithanhtoan', InvoiceStatus::Paid->value)
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

        return $query->groupBy('nam', 'thang')
            ->orderBy('nam')
            ->orderBy('thang')
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
