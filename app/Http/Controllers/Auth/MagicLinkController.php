<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MagicLinkController extends Controller
{
    public function login(Request $request, int $user_id)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Link đăng nhập đã hết hạn hoặc không hợp lệ.');
        }

        $user = User::findOrFail($user_id);

        if (! $user->is_active) {
            abort(403, 'Tài khoản của bạn đã bị vô hiệu hóa.');
        }

        Auth::login($user);

        $request->session()->regenerate();

        $request->session()->put('magic_login', true);

        return redirect()->route('profile.edit')
            ->with([
                'toast_loai' => 'thanhcong',
                'toast_noidung' => 'Đăng nhập thành công. Vui lòng đặt mật khẩu để lần sau đăng nhập nhanh hơn.',
            ]);
    }
}
