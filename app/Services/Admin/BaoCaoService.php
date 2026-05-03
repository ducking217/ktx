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
        // 1. Doanh thu 12 tháng gần nhất
        $doanhThuTheoThang = Hoadon::selectRaw('MONTH(updated_at) as thang, YEAR(updated_at) as nam, SUM(tongtien) as tong, COUNT(*) as so_luong')
            ->where('trangthaithanhtoan', InvoiceStatus::Paid->value)
            ->where('updated_at', '>=', now()->subMonths(12))
            ->groupBy('nam', 'thang')
            ->orderBy('nam')
            ->orderBy('thang')
            ->get();

        // 2. Tổng cọc đang giữ (Hóa đơn LOAI_DEPOSIT đã thanh toán)
        $tongCocHienTai = (float) Hoadon::where('loai_hoadon', Hoadon::LOAI_DEPOSIT)
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

        $query = Hoadon::selectRaw('MONTH(updated_at) as thang, YEAR(updated_at) as nam, COUNT(*) as so_luong, SUM(tongtien) as tong')
            ->where('trangthaithanhtoan', InvoiceStatus::Paid->value)
            ->whereYear('updated_at', $nam);

        if ($thang) {
            $query->whereMonth('updated_at', $thang);
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
                $query->whereIn(DB::raw('MONTH(updated_at)'), $months);
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
