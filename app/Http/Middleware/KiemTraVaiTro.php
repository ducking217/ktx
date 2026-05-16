<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KiemTraVaiTro
{
    /**
     * Kiểm tra vai trò đăng nhập theo route middleware.
     * Logic đơn giản: Chỉ chấp nhận 3 role: admin, sinhvien, guest
     */
    public function handle(Request $request, Closure $next, string $vaitrobatbuoc): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        /** @var \App\Models\User $nguoiDung */
        $nguoiDung = Auth::user();
        $vaitrohientai = $nguoiDung->vaitro ?? null;

        // Parse danh sách vai trò yêu cầu (hỗ trợ nhiều vai trò cách nhau bởi dấu phẩy)
        $danhSachVaiTroBatBuoc = collect(explode(',', $vaitrobatbuoc))
            ->map(static fn (string $vaiTro): string => trim($vaiTro))
            ->filter()
            ->values();

        // Chuyển đổi vai trò hiện tại sang string để so sánh
        $vaitroValue = $vaitrohientai instanceof \App\Enums\UserRole 
            ? $vaitrohientai->value 
            : (string) $vaitrohientai;

        // Kiểm tra trực tiếp - không cần mapping phức tạp
        $dungVaiTro = $danhSachVaiTroBatBuoc->contains($vaitroValue);

        if (! $dungVaiTro) {
            return redirect()
                ->route('dashboard')
                ->with('toast_loai', 'loi')
                ->with('toast_noidung', 'Bạn không có quyền truy cập chức năng này.');
        }

        return $next($request);
    }
}
