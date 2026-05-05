<?php

namespace Tests\Feature;

use App\Enums\RegistrationStatus;
use App\Models\Dangky;
use App\Models\Phong;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class GuestLookupTest extends TestCase
{
    use RefreshDatabase;

    public function test_magic_link_login_redirects_to_dieuhuong(): void
    {
        $user = \App\Models\User::factory()->create([
            'vaitro' => \App\Enums\UserRole::SinhVien,
            'is_active' => true,
        ]);

        $url = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'magic-link.login',
            now()->addMinutes(10),
            ['user_id' => $user->id]
        );

        $resp = $this->get($url);
        $resp->assertRedirect(route('profile.edit'));
    }

    public function test_magic_login_can_set_password_without_current_password(): void
    {
        $user = \App\Models\User::factory()->create();

        $resp = $this->actingAs($user)
            ->withSession(['magic_login' => true])
            ->put(route('password.update'), [
                'password' => 'NewPassword123!',
                'password_confirmation' => 'NewPassword123!',
            ]);

        $resp->assertRedirect();
        $user->refresh();
        $this->assertTrue(Hash::check('NewPassword123!', $user->password));
    }

    public function test_tra_cuu_hop_le_hien_thi_du_lieu_khong_bi_error(): void
    {
        $phong = Phong::factory()->create();
        $token = Str::random(32);

        Dangky::query()->create([
            'ho_ten' => 'Nguyen Van A',
            'email' => 'guest@example.com',
            'toa_nha_id' => $phong->toa_nha_id,
            'loai_phong_id' => $phong->loai_phong_id,
            'phong_id' => $phong->id,
            'trang_thai' => RegistrationStatus::Pending->value,
            'lookup_token' => $token,
            'token_expires_at' => now()->addHours(24),
            'phone_encrypted' => encrypt('0912345678'),
            'id_card_encrypted' => encrypt('012345678912'),
        ]);

        $resp = $this->get(route('guest.lookup', ['token' => $token]));
        $resp->assertOk();
        $resp->assertSee('Hồ sơ #');
        $resp->assertSee('guest@example.com');
    }

    public function test_tra_cuu_ma_khong_hop_le_hien_thi_thong_bao(): void
    {
        $resp = $this->get(route('guest.lookup', ['token' => 'invalid-token']));
        $resp->assertOk();
        $resp->assertSee('Mã tra cứu không tồn tại');
    }

    public function test_tra_cuu_token_null_khong_bao_loi(): void
    {
        $resp = $this->get(route('guest.lookup'));
        $resp->assertOk();
        $resp->assertSee('Kiểm tra ngay');
    }
}
