<?php

namespace Tests\Feature;

use App\Enums\BedStatus;
use App\Enums\ContractStatus;
use App\Enums\InvoiceStatus;
use App\Enums\RegistrationStatus;
use App\Models\Dangky;
use App\Models\Hopdong;
use App\Models\Hoadon;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tests\TestCase;

class HopdongTest extends TestCase
{
    use RefreshDatabase;

    private function taoAdmin(): User
    {
        return User::factory()->superAdmin()->create([
            'name' => 'Admin Test',
            'email' => 'admin@example.com',
        ]);
    }

    private function taoSinhVienVaPhong(): array
    {
        $toaNha = \App\Models\ToaNha::factory()->create();
        $phong = Phong::factory()->create([
            'toa_nha_id' => $toaNha->id,
            'ten_phong' => 'A101',
        ]);

        $user = User::factory()->sinhvien()->create([
            'name' => 'SV Test',
            'email' => 'svtest@example.com',
        ]);

        $sinhvien = Sinhvien::factory()->create([
            'user_id' => $user->id,
            'ma_sinh_vien' => 'SV001',
            'lop' => 'CNTT1',
        ]);

        return compact('phong', 'sinhvien', 'user');
    }

    public function test_admin_duyet_dangky_tao_hopdong()
    {
        Mail::fake();

        $admin = $this->taoAdmin();
        $data = $this->taoSinhVienVaPhong();

        $giuong = \App\Models\Giuong::factory()->create([
            'phong_id' => $data['phong']->id,
            'trang_thai' => BedStatus::Available->value,
        ]);

        $dangky = Dangky::create([
            'user_id' => $data['user']->id,
            'toa_nha_id' => $data['phong']->toa_nha_id,
            'loai_phong_id' => $data['phong']->loai_phong_id,
            'phong_id' => null,
            'lookup_token' => Str::random(32),
            'token_expires_at' => now()->addHours(24),
            'trang_thai' => RegistrationStatus::ApprovedPendingPayment->value,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.dangky.xacnhanthanhtoan', $dangky->id));

        $response->assertRedirect();

        $this->assertDatabaseHas('hopdong', [
            'sinhvien_id' => $data['sinhvien']->id,
            'phong_id' => $data['phong']->id,
            'giuong_id' => $giuong->id,
            'trang_thai' => ContractStatus::Active->value,
        ]);

        $this->assertDatabaseHas('giuong', [
            'id' => $giuong->id,
            'trang_thai' => BedStatus::Occupied->value,
        ]);
    }

    public function test_admin_giahan_hopdong()
    {
        $admin = $this->taoAdmin();
        $data = $this->taoSinhVienVaPhong();

        $giuong = \App\Models\Giuong::factory()->create(['phong_id' => $data['phong']->id]);
        $hopdong = Hopdong::factory()->create([
            'sinhvien_id' => $data['sinhvien']->id,
            'phong_id' => $data['phong']->id,
            'giuong_id' => $giuong->id,
            'ngay_bat_dau' => now()->format('Y-m-d'),
            'ngay_ket_thuc' => now()->addMonths(3)->format('Y-m-d'),
            'trang_thai' => ContractStatus::Active->value,
        ]);

        $ngayKetThucMoi = now()->addMonths(5)->format('Y-m-d');

        $response = $this->actingAs($admin)->post(route('admin.hopdong.giahan', $hopdong->id), ['ngay_ket_thuc' => $ngayKetThucMoi]);
        $response->assertRedirect();

        $hopdong->refresh();
        $this->assertEquals($ngayKetThucMoi, $hopdong->ngay_ket_thuc->format('Y-m-d'));
    }

    public function test_admin_thanhly_hopdong_va_giai_phong()
    {
        $admin = $this->taoAdmin();
        $data = $this->taoSinhVienVaPhong();

        $giuong = \App\Models\Giuong::factory()->create([
            'phong_id' => $data['phong']->id,
            'trang_thai' => BedStatus::Occupied->value,
        ]);
        $hopdong = Hopdong::factory()->create([
            'sinhvien_id' => $data['sinhvien']->id,
            'phong_id' => $data['phong']->id,
            'giuong_id' => $giuong->id,
            'ngay_bat_dau' => now()->subMonths(3)->format('Y-m-d'),
            'ngay_ket_thuc' => now()->addMonths(2)->format('Y-m-d'),
            'trang_thai' => ContractStatus::Active->value,
        ]);

        Hoadon::create([
            'hopdong_id' => $hopdong->id,
            'phong_id' => $data['phong']->id,
            'ma_hoa_don' => 'DEPOSIT-TEST-' . $hopdong->id,
            'loai_hoadon' => 'deposit',
            'tien_phong' => 0,
            'tien_dien' => 0,
            'tien_nuoc' => 0,
            'phi_dich_vu' => 500000,
            'tong_tien' => 500000,
            'trang_thai' => InvoiceStatus::Paid->value,
            'ngay_thanh_toan' => now()->toDateString(),
            'ngay_het_han' => now()->toDateString(),
            'ghi_chu' => 'Test deposit paid',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.hopdong.thanhly', $hopdong->id));
        $response->assertRedirect();

        $this->assertDatabaseHas('hopdong', [
            'id' => $hopdong->id,
            'trang_thai' => ContractStatus::Terminated->value,
        ]);

        $this->assertDatabaseHas('hoadon', [
            'hopdong_id' => $hopdong->id,
            'loai_hoadon' => 'refund',
            'tong_tien' => 500000,
        ]);

        $this->assertDatabaseHas('giuong', [
            'id' => $giuong->id,
            'trang_thai' => BedStatus::Available->value,
        ]);
    }

    public function test_admin_chuyen_phong_cap_nhat_hopdong_da_thanh_ly()
    {
        $admin = $this->taoAdmin();
        $data = $this->taoSinhVienVaPhong();

        $phong2 = Phong::factory()->create([
            'toa_nha_id' => $data['phong']->toa_nha_id,
            'loai_phong_id' => $data['phong']->loai_phong_id,
            'ten_phong' => 'A102',
        ]);

        $giuong1 = \App\Models\Giuong::factory()->create([
            'phong_id' => $data['phong']->id,
            'trang_thai' => BedStatus::Occupied->value,
        ]);
        $giuong2 = \App\Models\Giuong::factory()->create([
            'phong_id' => $phong2->id,
            'trang_thai' => BedStatus::Available->value,
        ]);

        $hopdong = Hopdong::factory()->create([
            'sinhvien_id' => $data['sinhvien']->id,
            'phong_id' => $data['phong']->id,
            'giuong_id' => $giuong1->id,
            'ngay_bat_dau' => now()->subMonths(3)->format('Y-m-d'),
            'ngay_ket_thuc' => now()->addMonths(2)->format('Y-m-d'),
            'trang_thai' => ContractStatus::Active->value,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.sinhvien.choroiophong', $data['sinhvien']->id));
        $response->assertRedirect();

        $this->assertDatabaseHas('hopdong', [
            'id' => $hopdong->id,
            'trang_thai' => ContractStatus::Terminated->value,
        ]);
        $this->assertDatabaseHas('giuong', [
            'id' => $giuong1->id,
            'trang_thai' => BedStatus::Available->value,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.sinhvien.chuyenphong', $data['sinhvien']->id), [
            'phong_id' => $phong2->id,
        ]);
        $response->assertRedirect();

        $this->assertDatabaseHas('hopdong', [
            'sinhvien_id' => $data['sinhvien']->id,
            'phong_id' => $phong2->id,
            'giuong_id' => $giuong2->id,
            'trang_thai' => ContractStatus::Active->value,
        ]);
        $this->assertDatabaseHas('giuong', [
            'id' => $giuong2->id,
            'trang_thai' => BedStatus::Occupied->value,
        ]);
    }
}
