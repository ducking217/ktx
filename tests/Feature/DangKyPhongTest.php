<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Phong;
use App\Models\Dangky;
use App\Models\Sinhvien;
use App\Models\Hopdong;
use App\Models\Giuong;
use App\Models\LoaiPhong;
use App\Models\ToaNha;
use App\Enums\RegistrationStatus;
use App\Enums\ContractStatus;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tests\TestCase;

class DangKyPhongTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_co_the_dang_ky_phong(): void
    {
        $phong = Phong::factory()->create();
        Giuong::factory()->create([
            'phong_id' => $phong->id,
            'trang_thai' => \App\Enums\BedStatus::Available,
        ]);

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
            'trang_thai' => RegistrationStatus::Pending->value,
        ]);
    }

    public function test_admin_duyet_ho_so(): void
    {
        Mail::fake();
        $this->withoutMiddleware();

        $admin = User::factory()->create(['vaitro' => UserRole::Admin]);
        $phong = Phong::factory()->create();
        $dangky = Dangky::query()->create([
            'ho_ten' => 'Guest',
            'email' => 'guest@example.com',
            'toa_nha_id' => $phong->toa_nha_id,
            'loai_phong_id' => $phong->loai_phong_id,
            'phong_id' => $phong->id,
            'trang_thai' => RegistrationStatus::Pending->value,
            'lookup_token' => Str::random(32),
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.dangky.duyethoso', $dangky->id));

        $response->assertSessionHasNoErrors();
        $this->assertEquals(RegistrationStatus::ApprovedPendingPayment->value, $dangky->fresh()->trang_thai->value);
    }

    public function test_admin_xac_nhan_thanh_toan(): void
    {
        $this->withoutMiddleware();

        $admin = User::factory()->create(['vaitro' => UserRole::Admin]);
        $toaNha = ToaNha::factory()->create();
        $loaiPhong = LoaiPhong::factory()->create();
        $phong = Phong::factory()->create([
            'toa_nha_id' => $toaNha->id,
            'loai_phong_id' => $loaiPhong->id,
        ]);
        Giuong::factory()->create([
            'phong_id' => $phong->id,
            'trang_thai' => \App\Enums\BedStatus::Available,
        ]);

        $dangky = Dangky::query()->create([
            'ho_ten' => 'Sinh Vien Test',
            'email' => 'sv_unique@example.com',
            'toa_nha_id' => $toaNha->id,
            'loai_phong_id' => $loaiPhong->id,
            'phong_id' => $phong->id,
            'trang_thai' => RegistrationStatus::ApprovedPendingPayment->value,
            'lookup_token' => Str::random(32),
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.dangky.xacnhanthanhtoan', $dangky->id));

        $response->assertSessionHasNoErrors();
        $this->assertEquals(RegistrationStatus::Completed->value, $dangky->fresh()->trang_thai->value);
    }

    public function test_admin_cho_sinh_vien_roi_o_phong(): void
    {
        $admin = User::factory()->create(['vaitro' => UserRole::Admin]);
        $phong = Phong::factory()->create();
        $giuong = Giuong::factory()->create([
            'phong_id' => $phong->id,
            'trang_thai' => \App\Enums\BedStatus::Occupied,
        ]);
        $sinhvien = Sinhvien::factory()->create();
        $hopdong = Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien->id,
            'phong_id' => $phong->id,
            'giuong_id' => $giuong->id,
            'trang_thai' => ContractStatus::Active,
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.sinhvien.choroiophong', $sinhvien->id));
        $response->assertSessionHasNoErrors();

        $this->assertEquals(ContractStatus::Terminated->value, $hopdong->fresh()->trang_thai->value);
        $this->assertEquals(\App\Enums\BedStatus::Available->value, $giuong->fresh()->trang_thai->value);
    }
}
