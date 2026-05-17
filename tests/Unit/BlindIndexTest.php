<?php

namespace Tests\Unit;

use App\Models\Dangky;
use App\Models\Phong;
use App\Enums\RegistrationStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlindIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_blind_index_tao_tu_dong_khi_luu_dangky()
    {
        $phong = Phong::factory()->create();
        $phone = '0912345678';
        $cccd = '123456789';

        $dangky = Dangky::create([
            'ho_ten' => 'Nguyễn Văn A',
            'email' => 'nguyenvana@example.com',
            'phone_encrypted' => encrypt($phone),
            'id_card_encrypted' => encrypt($cccd),
            'toa_nha_id' => $phong->toa_nha_id,
            'loai_phong_id' => $phong->loai_phong_id,
            'phong_id' => $phong->id,
            'trang_thai' => RegistrationStatus::Pending,
            'lookup_token' => 'test-token',
        ]);

        $this->assertSame($phone, $dangky->so_dien_thoai);
        $this->assertSame($cccd, $dangky->cccd);
        $this->assertNotSame($phone, $dangky->phone_encrypted);
        $this->assertNotSame($cccd, $dangky->id_card_encrypted);
    }

    public function test_tim_kiem_bang_so_dien_thoai_tren_du_lieu_ma_hoa()
    {
        $phong1 = Phong::factory()->create();
        $phong2 = Phong::factory()->create();

        Dangky::create([
            'ho_ten' => 'Nguyễn Văn A',
            'email' => 'nguyenvana@example.com',
            'phone_encrypted' => encrypt('0912345678'),
            'id_card_encrypted' => encrypt('123456789'),
            'toa_nha_id' => $phong1->toa_nha_id,
            'loai_phong_id' => $phong1->loai_phong_id,
            'phong_id' => $phong1->id,
            'trang_thai' => RegistrationStatus::Pending,
            'lookup_token' => 'test-token-1',
        ]);

        Dangky::create([
            'ho_ten' => 'Trần Thị B',
            'email' => 'tranthib@example.com',
            'phone_encrypted' => encrypt('0987654321'),
            'id_card_encrypted' => encrypt('987654321'),
            'toa_nha_id' => $phong2->toa_nha_id,
            'loai_phong_id' => $phong2->loai_phong_id,
            'phong_id' => $phong2->id,
            'trang_thai' => RegistrationStatus::Pending,
            'lookup_token' => 'test-token-2',
        ]);

        $result = Dangky::where('lookup_token', 'test-token-1')->first();
        $this->assertNotNull($result);
        $this->assertSame('Nguyễn Văn A', $result->ho_ten);

        $result2 = Dangky::where('lookup_token', 'test-token-2')->first();
        $this->assertNotNull($result2);
        $this->assertSame('Trần Thị B', $result2->ho_ten);
    }
}
