<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\BaoCaoServiceInterface;
use App\Exports\BaoCaoTaiChinhExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BaoCaoController extends Controller
{
    public function __construct(
        private readonly BaoCaoServiceInterface $baoCaoService
    ) {}

    public function taiChinh()
    {
        $data = $this->baoCaoService->layDuLieuTaiChinh();
        return view('admin.baocao.taichinh', $data);
    }

    public function xuatExcel(Request $request)
    {
        $filters = $request->only(['thang', 'nam', 'quy']);
        $data = $this->baoCaoService->layDuLieuExport($filters);

        $baseName = 'Bao-cao-tai-chinh-' . now()->format('Y-m-d');

        try {
            return Excel::download(new BaoCaoTaiChinhExport($data), $baseName . '.xlsx');
        } catch (\Throwable $e) {
            return response()->streamDownload(function () use ($data) {
                echo "\xEF\xBB\xBF";
                $out = fopen('php://output', 'w');
                fputcsv($out, ['Tháng', 'Năm', 'Số hóa đơn', 'Tổng doanh thu', 'Trung bình/HĐ']);
                foreach ($data as $row) {
                    fputcsv($out, [
                        $row['thang'] ?? null,
                        $row['nam'] ?? null,
                        $row['so_luong'] ?? null,
                        $row['tong'] ?? null,
                        $row['trung_binh'] ?? null,
                    ]);
                }
                fclose($out);
            }, $baseName . '.csv', [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ]);
        }
    }
}
