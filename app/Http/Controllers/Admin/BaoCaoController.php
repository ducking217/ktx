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
        
        $fileName = 'Bao-cao-tai-chinh-' . now()->format('Y-m-d') . '.xlsx';
        
        return Excel::download(new BaoCaoTaiChinhExport($data), $fileName);
    }
}
