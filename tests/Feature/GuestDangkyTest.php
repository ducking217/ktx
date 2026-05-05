<?php

namespace Tests\Feature;

use App\Enums\BedStatus;
use App\Mail\DangkyKhachThanhCongMail;
use App\Models\Dangky;
use App\Models\Giuong;
use App\Models\Phong;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class GuestDangkyTest extends TestCase
{
    use RefreshDatabase;

    public function test_khach_dang_ky_thanh_cong_va_tao_dangky_day_du_thong_tin(): void
    {
        Mail::fake();

        $phong = Phong::factory()->create();
        Giuong::factory()->create([
            'phong_id' => $phong->id,
            'ma_giuong' => 'P' . $phong->id . '-G1',
            'trang_thai' => BedStatus::Available,
        ]);

        $payload = [
            'phong_id' => $phong->id,
            'ho_ten' => 'Nguyen Van A',
            'email' => 'guest@example.com',
            'so_dien_thoai' => '0912345678',
            'so_cccd' => '012345678912',
        ];

        $response = $this->post(route('guest.dangky.store'), $payload);

        $response->assertStatus(302);
        $response->assertSessionHas('toast_loai', 'thanhcong');

        $dangky = Dangky::query()->where('email', 'guest@example.com')->first();
        $this->assertNotNull($dangky);
        $this->assertSame($phong->id, $dangky->phong_id);
        $this->assertSame($phong->toa_nha_id, $dangky->toa_nha_id);
        $this->assertSame($phong->loai_phong_id, $dangky->loai_phong_id);
        $this->assertNotNull($dangky->lookup_token);
        $this->assertNotNull($dangky->token_expires_at);

        Mail::assertQueued(DangkyKhachThanhCongMail::class);
    }
}
