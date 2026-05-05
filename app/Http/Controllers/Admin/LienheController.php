<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Core\TienIchServiceInterface;
use App\Http\Requests\Admin\CapNhatTrangThaiLienHeRequest;
use App\Models\Lienhe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LienheController extends Controller
{
    public function __construct(
        private readonly TienIchServiceInterface $tienIchService
    ) {}

    public function index(Request $request)
    {
        $duLieuLienHe = $this->tienIchService->danhSachLienHe($request);
        return view('admin.lienhe.danhsach', $duLieuLienHe);
    }

    public function update(CapNhatTrangThaiLienHeRequest $request, int $id)
    {
        $duLieu = $request->validated();
        $guiEmail = (bool) ($duLieu['gui_email'] ?? false);

        $lienhe = Lienhe::find($id);
        if (! $lienhe) {
            return redirect()->back()->with([
                'toast_loai' => 'loi',
                'toast_noidung' => 'Không tìm thấy liên hệ.',
            ]);
        }

        if ($guiEmail) {
            try {
                $noiDungPhanHoi = trim((string) ($duLieu['ghi_chu_admin'] ?? ''));
                if ($noiDungPhanHoi === '') {
                    return redirect()->back()->with([
                        'toast_loai' => 'loi',
                        'toast_noidung' => 'Vui lòng nhập nội dung phản hồi trước khi gửi email.',
                    ]);
                }
                $subject = 'Phản hồi liên hệ từ Ban quản lý KTX';

                $body = "Xin chào {$lienhe->ho_ten},\n\n";
                $body .= $noiDungPhanHoi . "\n\n";
                $body .= "—\n";
                $body .= "Nội dung bạn đã gửi:\n";
                $body .= $lienhe->noi_dung . "\n";

                Mail::raw($body, function ($message) use ($lienhe, $subject) {
                    $message->to($lienhe->email)->subject($subject);
                });
            } catch (\Throwable $e) {
                return redirect()->back()->with([
                    'toast_loai' => 'loi',
                    'toast_noidung' => 'Không thể gửi email phản hồi. Vui lòng kiểm tra cấu hình mail.',
                ]);
            }
        }

        $this->tienIchService->capNhatTrangThaiLienHe($id, $duLieu['trang_thai'], $duLieu['ghi_chu_admin'] ?? null);

        return redirect()->back()->with([
            'toast_loai' => 'thanhcong',
            'toast_noidung' => $guiEmail ? 'Đã gửi phản hồi và cập nhật trạng thái liên hệ.' : 'Đã cập nhật liên hệ.',
        ]);
    }
}
