<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Contracts\Admin\AccountServiceInterface;
use App\Enums\Gender;
use App\Enums\UserRole;
use App\Models\User;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/**

 * Khu vực: Admin / Tài khoản
 
 * Vai trò: Quản trị tài khoản vận hành (tạo/sửa/xóa/khôi phục).

 */

class AccountService implements AccountServiceInterface
{
    use PhanHoiService;

    public function lietKe(Request $request): array
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('vaitro', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $escaped = \App\Helpers\SecurityHelper::escapeLike($search);
            $query->where(function ($q) use ($escaped) {
                $q->where('name', 'like', "%{$escaped}%")
                  ->orWhere('email', 'like', "%{$escaped}%");
            });
        }

        // Chỉ liệt kê các tài khoản thuộc nhóm Admin
        $query->whereIn('vaitro', [
            UserRole::Admin->value,
        ]);

        return [
            'accounts' => $query->orderBy('vaitro')->paginate(20)->withQueryString(),
        ];
    }

    public function luu(array $data): array
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'vaitro' => $data['vaitro'],
                'is_active' => $data['is_active'] ?? true,
                'gender' => $data['gender'] ?? Gender::Male,
                'toa_nha_id' => $data['toa_nha_id'] ?? null,
            ]);

            return $this->traVeThanhCong('Tạo tài khoản thành công.', ['user' => $user]);
        } catch (\Throwable $e) {
            Log::error('AccountService.luu failed', ['exception' => $e]);
            $message = config('app.debug') ? ('Không thể tạo tài khoản: ' . $e->getMessage()) : 'Không thể tạo tài khoản.';
            return $this->traVeLoi($message);
        }
    }

    public function capNhat(int $id, array $data): array
    {
        try {
            $user = User::findOrFail($id);
            $currentUser = Auth::user();

            // 1. Không cho phép đổi role của chính mình
            if ($currentUser->id === $user->id && isset($data['vaitro']) && $data['vaitro'] !== $user->vaitro->value) {
                return $this->traVeLoi('Bạn không thể tự thay đổi vai trò của chính mình.');
            }

            // 2. Kiểm tra nếu là Super Admin cuối cùng
            if ($user->vaitro === UserRole::Admin && isset($data['vaitro']) && $data['vaitro'] !== UserRole::Admin->value) {
                $count = User::where('vaitro', UserRole::Admin->value)->count();
                if ($count <= 1) {
                    return $this->traVeLoi('Không thể thay đổi vai trò của Super Admin cuối cùng.');
                }
            }

            $updateData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'vaitro' => $data['vaitro'],
                'is_active' => $data['is_active'] ?? $user->is_active,
                'toa_nha_id' => $data['toa_nha_id'] ?? $user->toa_nha_id,
                'gender' => $data['gender'] ?? $user->gender,
            ];

            if (!empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            $user->update($updateData);

            return $this->traVeThanhCong('Cập nhật tài khoản thành công.', ['user' => $user]);
        } catch (\Throwable $e) {
            Log::error('AccountService.capNhat failed', ['user_id' => $id, 'exception' => $e]);
            $message = config('app.debug') ? ('Lỗi khi cập nhật: ' . $e->getMessage()) : 'Lỗi khi cập nhật.';
            return $this->traVeLoi($message);
        }
    }

    public function xoa(int $id): array
    {
        try {
            $user = User::findOrFail($id);

            // 1. Không cho phép tự xóa chính mình
            if (Auth::id() === $user->id) {
                return $this->traVeLoi('Bạn không thể tự xóa tài khoản đang đăng nhập.');
            }

            // 2. Không cho phép xóa Super Admin cuối cùng
            if ($user->vaitro === UserRole::Admin) {
                $count = User::where('vaitro', UserRole::Admin->value)->count();
                if ($count <= 1) {
                    return $this->traVeLoi('Không thể xóa Super Admin cuối cùng của hệ thống.');
                }
            }

            $user->delete();

            return $this->traVeThanhCong('Đã xóa tài khoản.');
        } catch (\Throwable $e) {
            Log::error('AccountService.xoa failed', ['user_id' => $id, 'exception' => $e]);
            $message = config('app.debug') ? ('Lỗi khi xóa: ' . $e->getMessage()) : 'Lỗi khi xóa.';
            return $this->traVeLoi($message);
        }
    }
}
