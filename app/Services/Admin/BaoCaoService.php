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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**

 * Khu vực: Admin / Báo cáo
 
 * Vai trò: Tổng hợp số liệu báo cáo (đặc biệt báo cáo tài chính) và tối ưu truy vấn aggregate theo năm.

 */

class BaoCaoService implements BaoCaoServiceInterface
{
    public function layDuLieuTaiChinh(?int $nam = null): array
    {
        $nam = $nam ?: now()->year;

        return Cache::remember("admin.baocao.taichinh:v1:{$nam}", now()->addMinutes(5), function () use ($nam): array {
            $driver = DB::connection()->getDriverName();
            $monthExpr = $driver === 'sqlite'
                ? "CAST(strftime('%m', ngay_thanh_toan) AS INTEGER)"
                : 'MONTH(ngay_thanh_toan)';
            $yearExpr = $driver === 'sqlite'
                ? "CAST(strftime('%Y', ngay_thanh_toan) AS INTEGER)"
                : 'YEAR(ngay_thanh_toan)';

            $doanhThuTheoThang = Hoadon::selectRaw("{$monthExpr} as thang, {$yearExpr} as nam, SUM(tong_tien) as tong, COUNT(*) as so_luong")
                ->where('trang_thai', InvoiceStatus::Paid)
                ->whereNotNull('ngay_thanh_toan')
                ->whereYear('ngay_thanh_toan', $nam)
                ->groupBy(DB::raw($yearExpr), DB::raw($monthExpr))
                ->orderBy(DB::raw($yearExpr))
                ->orderBy(DB::raw($monthExpr))
                ->get();

            $tongCocHienTai = (float) Hoadon::where('loai_hoadon', Hoadon::LOAI_DEPOSIT)
                ->where('trang_thai', InvoiceStatus::Paid)
                ->sum('tong_tien');

            $tongPhong = Phong::count();
            $phongDangThue = Phong::whereHas('giuongs', function ($query) {
                $query->where('trang_thai', BedStatus::Occupied->value);
            })->count();
            $tyLeLapDay = $tongPhong > 0 ? round(($phongDangThue / $tongPhong) * 100, 1) : 0;

            $topPhong = Hoadon::selectRaw('phong_id, SUM(tong_tien) as tong')
                ->where('trang_thai', InvoiceStatus::Paid)
                ->whereNotNull('ngay_thanh_toan')
                ->whereYear('ngay_thanh_toan', $nam)
                ->with('phong')
                ->groupBy('phong_id')
                ->orderByDesc('tong')
                ->limit(5)
                ->get();

            $thangNay = now()->month;
            $doanhThuThangNay = (float) Hoadon::where('trang_thai', InvoiceStatus::Paid)
                ->whereMonth('ngay_thanh_toan', $thangNay)
                ->whereYear('ngay_thanh_toan', $nam)
                ->sum('tong_tien');

            $thangTruoc = $thangNay === 1 ? 12 : ($thangNay - 1);
            $namTruoc = $thangNay === 1 ? ($nam - 1) : $nam;
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
        });
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
