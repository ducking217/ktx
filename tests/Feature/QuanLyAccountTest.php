<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class QuanLyAccountTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 1. test_super_admin_tao_account_thanh_cong
     */
    public function test_super_admin_tao_account_thanh_cong(): void
    {
        // Setup: đăng nhập super_admin
        $superAdmin = User::factory()->superAdmin()->create();
        
        $email = 'newadmin' . time() . '@example.com';
        $data = [
            'name' => 'New Admin',
            'email' => $email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'vaitro' => UserRole::Admin->value,
            'is_active' => true,
            'gender' => \App\Enums\Gender::Male->value,
        ];

        // Action: POST /admin/accounts
        $response = $this->actingAs($superAdmin)
            ->post(route('admin.accounts.luu'), $data);

        if ($response->getSession()->has('error')) {
            $this->fail((string) $response->getSession()->get('error'));
        }

        $response->assertRedirect(route('admin.accounts.index'));
        $response->assertSessionHas('success');

        // Assert: DB có user với email đó
        $this->assertDatabaseHas('users', [
            'email' => $email,
            'name' => 'New Admin',
            'vaitro' => UserRole::Admin->value,
        ]);

        // Assert: password đã hash (assertNotEquals raw vs stored)
        $user = User::where('email', $email)->first();
        $this->assertNotEquals('password123', $user->password);
        $this->assertTrue(Hash::check('password123', $user->password));

        // Assert: response redirect về index
    }

    /**
     * 2. test_guest_va_sinhvien_khong_the_truy_cap_quan_ly_account
     */
    public function test_guest_va_sinhvien_khong_the_truy_cap_quan_ly_account(): void
    {
        // Action 1: Guest (chưa đăng nhập)
        $responseGuest = $this->get(route('admin.accounts.index'));
        $responseGuest->assertRedirect(route('login'));

        // Setup 2: Đăng nhập với tài khoản SV
        $sinhVien = User::factory()->sinhvien()->create();

        // Action 2: GET /admin/accounts
        $responseSV = $this->actingAs($sinhVien)
            ->get(route('admin.accounts.index'));

        // Assert: response redirect về dashboard (do middleware KiemTraVaiTro xử lý)
        $responseSV->assertRedirect(route('dashboard'));
    }

    /**
     * 3. test_khong_the_xoa_super_admin_cuoi_cung
     */
    public function test_khong_the_xoa_super_admin_cuoi_cung(): void
    {
        // Setup: chỉ còn 1 super_admin trong DB
        $superAdmin = User::factory()->superAdmin()->create();
        
        // Tạo thêm 1 Super Admin khác để có quyền thực hiện lệnh xóa
        $executor = User::factory()->superAdmin()->create();
        
        // DB có 2 super admin: $superAdmin và $executor. 
        // Xóa $superAdmin -> Còn $executor -> OK.
        $this->actingAs($executor)->delete(route('admin.accounts.xoa', $superAdmin->id));
        $this->assertSoftDeleted('users', ['id' => $superAdmin->id]);

        // Bây giờ $executor là Super Admin duy nhất. 
        // Thử xóa $executor.
        // Lưu ý: AccountService dùng PhanHoiService, trả về array['success' => false] 
        // và Controller dùng ->with('error', ...)
        $response = $this->actingAs($executor)->delete(route('admin.accounts.xoa', $executor->id));
        
        // Assert: Lỗi (do tự xóa hoặc super admin cuối cùng)
        $response->assertSessionHas('error');
        $this->assertNotSoftDeleted('users', ['id' => $executor->id]);
        $this->assertEquals(1, User::where('vaitro', UserRole::Admin->value)->count());
    }

    /**
     * 4. test_khong_the_tu_xoa_chinh_minh
     */
    public function test_khong_the_tu_xoa_chinh_minh(): void
    {
        // Setup: đăng nhập super_admin_A, và có 1 super_admin_B khác để A không phải là người cuối cùng
        $superAdminA = User::factory()->superAdmin()->create();
        $superAdminB = User::factory()->superAdmin()->create();

        // Action: DELETE /admin/accounts/{id_cua_A}
        $response = $this->actingAs($superAdminA)
            ->delete(route('admin.accounts.xoa', $superAdminA->id));

        // Assert: response lỗi, user A vẫn tồn tại trong DB
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', [
            'id' => $superAdminA->id,
            'deleted_at' => null
        ]);
    }

    /**
     * 5. test_khoi_phuc_account_da_xoa
     */
    public function test_khoi_phuc_account_da_xoa(): void
    {
        // Setup: soft-delete 1 user trước
        $superAdmin = User::factory()->superAdmin()->create();
        $userToDelete = User::factory()->admin()->create();
        $userToDelete->delete();
        $this->assertSoftDeleted('users', ['id' => $userToDelete->id]);

        // Action: POST /admin/accounts/{id}/restore
        $response = $this->actingAs($superAdmin)
            ->post(route('admin.accounts.restore', $userToDelete->id));

        // Assert: DB user đó có deleted_at = null (đã restore)
        $this->assertDatabaseHas('users', [
            'id' => $userToDelete->id,
            'deleted_at' => null
        ]);

        // Assert: user có thể đăng nhập lại
        $this->assertTrue(auth()->attempt([
            'email' => $userToDelete->email,
            'password' => 'password'
        ]));
    }
}
