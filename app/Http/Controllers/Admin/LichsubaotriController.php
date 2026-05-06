<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\BaoTriServiceInterface;
use App\Models\Lichsubaotri;
use Illuminate\Http\Request;

class LichsubaotriController extends Controller
{
    public function __construct(
        private readonly BaoTriServiceInterface $baoTriService
    ) {}

    public function index(Request $request)
    {
        $duLieuBaoTri = $this->baoTriService->lietKeBaoTri($request);
        return view('admin.baotri.danhsach', $duLieuBaoTri);
    }

    public function xuatExcel(Request $request)
    {
        $tuKhoa = (string) $request->query('q', '');

        $query = Lichsubaotri::with(['phong', 'vattu']);
        if ($tuKhoa !== '') {
            $query->whereHas('phong', function ($pq) use ($tuKhoa) {
                $pq->where('ten_phong', 'like', '%' . \App\Helpers\SecurityHelper::escapeLike($tuKhoa) . '%');
            });
        }

        $data = $query->orderByDesc('ngay_bao_tri')->get();
        $baseName = 'Lich-bao-tri-' . now()->format('Y-m-d');

        return response()->streamDownload(function () use ($data) {
            echo "\xEF\xBB\xBF";
            $out = fopen('php://output', 'w');
            fputcsv($out, ['ID', 'Phòng', 'Vật tư', 'Ngày bảo trì', 'Nội dung', 'Chi phí', 'Đơn vị thực hiện', 'Người thực hiện', 'Trạng thái']);
            foreach ($data as $item) {
                fputcsv($out, [
                    $item->id,
                    $item->phong?->ten_phong,
                    $item->vattu?->ten_vat_tu,
                    $item->ngay_bao_tri ? \Illuminate\Support\Carbon::parse($item->ngay_bao_tri)->format('d/m/Y') : null,
                    $item->noi_dung,
                    $item->chi_phi,
                    $item->don_vi_thuc_hien,
                    $item->nguoi_thuc_hien,
                    $item->trang_thai,
                ]);
            }
            fclose($out);
        }, $baseName . '.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function store(Request $request)
    {
        $dulieu = $request->validate([
            'phong_id' => ['nullable', 'exists:phong,id'],
            'vattu_id' => ['nullable', 'exists:vattu,id'],
            'ngay_bao_tri' => ['required', 'date'],
            'chi_phi' => ['nullable', 'numeric', 'min:0'],
            'noi_dung' => ['required', 'string'],
            'nguoi_thuc_hien' => ['required', 'string'],
            'trang_thai' => ['nullable', 'in:planned,done,cancelled'],
        ]);

        $ketQua = $this->baoTriService->luuBaoTri($dulieu);
        return redirect()->back()->with(['toast_loai' => $ketQua['toast_loai'], 'toast_noidung' => $ketQua['toast_noidung']]);
    }

    public function update(Request $request, int $id)
    {
        $dulieu = $request->validate([
            'phong_id' => ['nullable', 'exists:phong,id'],
            'vattu_id' => ['nullable', 'exists:vattu,id'],
            'ngay_bao_tri' => ['required', 'date'],
            'chi_phi' => ['nullable', 'numeric', 'min:0'],
            'noi_dung' => ['required', 'string'],
            'nguoi_thuc_hien' => ['required', 'string'],
            'trang_thai' => ['nullable', 'in:planned,done,cancelled'],
        ]);

        $ketQua = $this->baoTriService->luuBaoTri($dulieu, $id);
        return redirect()->back()->with(['toast_loai' => $ketQua['toast_loai'], 'toast_noidung' => $ketQua['toast_noidung']]);
    }

    public function hoanThanh(int $id)
    {
        $ketQua = $this->baoTriService->hoanThanhBaoTri($id);
        return redirect()->back()->with(['toast_loai' => $ketQua['toast_loai'], 'toast_noidung' => $ketQua['toast_noidung']]);
    }

    public function destroy(int $id)
    {
        $ketQua = $this->baoTriService->xoaBaoTri($id);
        return redirect()->back()->with(['toast_loai' => $ketQua['toast_loai'], 'toast_noidung' => $ketQua['toast_noidung']]);
    }
}
