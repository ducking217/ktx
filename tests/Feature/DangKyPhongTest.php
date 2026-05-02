<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Phong;
use App\Models\Dangky;
use App\Models\Sinhvien;
use App\Models\Hopdong;
use App\Enums\RegistrationStatus;
use App\Enums\ContractStatus;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class DangKyPhongTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_co_the_dang_ky_phong()
    {
        $phong = Phong::factory()->create();

        $data = [
            'phong_id' => $phong->id,
            'ho_ten' => 'Nguyen Van Test',
            'email' => 'test_unique@example.com',
            'so_dien_thoai' => '0912345678',
            'so_cccd' => '123456789',
            'anh_the' => \Illuminate\Http\UploadedFile::fake()->create('avatar.jpg', 100),
            'anh_cccd' => \Illuminate\Http\UploadedFile::fake()->create('cccd.jpg', 100),
        ];

        $response = $this->post(route('guest.dangky.store'), $data);
        
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('dangky', [
            'email' => 'test_unique@example.com',
            'trangthai' => RegistrationStatus::Pending->value,
        ]);
    }

    public function test_admin_duyet_ho_so()
    {
        Mail::fake();
        $admin = User::factory()->create(['vaitro' => UserRole::Admin]);
        $dangky = Dangky::factory()->create(['trangthai' => RegistrationStatus::Pending]);

        $response = $this->actingAs($admin)
            ->post(route('admin.duyethoso', $dangky->id));

        $response->assertSessionHasNoErrors();
        $this->assertEquals(RegistrationStatus::ApprovedPendingPayment, $dangky->fresh()->trangthai);
    }

    public function test_admin_xac_nhan_thanh_toan()
    {
        $admin = User::factory()->create(['vaitro' => UserRole::Admin]);
        $phong = Phong::factory()->create();
        $dangky = Dangky::factory()->create([
            'trangthai' => RegistrationStatus::ApprovedPendingPayment,
            'phong_id' => $phong->id,
            'ho_ten' => 'Sinh Vien Test',
            'email' => 'sv_unique@example.com',
            'so_dien_thoai' => '0987654321',
            'so_cccd' => '123456789012',
            'loaidangky' => \App\Enums\RegistrationType::Rental,
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.dangky.xacnhanthanhtoan', $dangky->id));

        $response->assertSessionHasNoErrors();
        $this->assertEquals(RegistrationStatus::Completed, $dangky->fresh()->trangthai);
    }

    public function test_sinhvien_tra_phong()
    {
        $admin = User::factory()->create(['vaitro' => UserRole::Admin]);
        $sinhvien = Sinhvien::factory()->create();
        $hopdong = Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien->id,
            'trang_thai' => ContractStatus::Active
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.choroiophong', $sinhvien->id));

        $this->assertEquals(ContractStatus::Terminated, $hopdong->fresh()->trang_thai);
        $this->assertNull($sinhvien->fresh()->phong_id);
    }
}
