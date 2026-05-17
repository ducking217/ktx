<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Phong;
use App\Models\Hoadon;
use App\Models\Sinhvien;
use App\Models\Giuong;
use App\Enums\InvoiceStatus;
use App\Enums\UserRole;
use App\Enums\BedStatus;
use App\Enums\ContractStatus;
use App\Contracts\Admin\HoadonServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HoadonTest extends TestCase
{
    use RefreshDatabase;

    public function test_tao_hoa_don_tu_dong()
    {
        $admin = User::factory()->create(['vaitro' => UserRole::Admin]);
        $phong = Phong::factory()->create();
        $sinhvien = Sinhvien::factory()->create();
        $giuong = Giuong::factory()->create(['phong_id' => $phong->id, 'trang_thai' => BedStatus::Occupied]);
        \App\Models\Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien->id,
            'phong_id' => $phong->id,
            'giuong_id' => $giuong->id,
            'trang_thai' => ContractStatus::Active,
        ]);

        $data = [
            'phong_id' => $phong->id,
            'thang' => now()->month,
            'nam' => now()->year,
            'chisodiencu' => 100,
            'chisodienmoi' => 150,
            'chisonuoccu' => 50,
            'chisonuocmoi' => 60,
        ];

        $service = app(HoadonServiceInterface::class);
        $result = $service->xuLyHoaDon($data);

        $this->assertEquals('thanhcong', $result['toast_loai']);
        $this->assertDatabaseHas('hoadon', [
            'phong_id' => $phong->id,
            'loai_hoadon' => 'monthly',
            'ghi_chu' => "Ky {$data['thang']}/{$data['nam']}",
            'trang_thai' => InvoiceStatus::Unpaid->value,
        ]);
    }

    public function test_thanh_toan_hoa_don()
    {
        $admin = User::factory()->create(['vaitro' => UserRole::Admin]);
        $hoadon = Hoadon::factory()->create(['trang_thai' => InvoiceStatus::Unpaid, 'ngay_thanh_toan' => null]);

        $response = $this->actingAs($admin)
            ->post(route('admin.hoadon.xacnhan', $hoadon->id));

        $response->assertRedirect();
        $this->assertEquals(InvoiceStatus::Paid, $hoadon->fresh()->trang_thai);
        $this->assertNotNull($hoadon->fresh()->ngay_thanh_toan);
    }

    public function test_khong_the_ghi_de_hoa_don_da_thanh_toan()
    {
        $phong = Phong::factory()->create();
        $thang = now()->month;
        $nam = now()->year;

        $sinhvien = Sinhvien::factory()->create();
        $giuong = Giuong::factory()->create(['phong_id' => $phong->id, 'trang_thai' => BedStatus::Occupied]);
        \App\Models\Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien->id,
            'phong_id' => $phong->id,
            'giuong_id' => $giuong->id,
            'trang_thai' => ContractStatus::Active,
        ]);

        $hoadon = Hoadon::factory()->create([
            'phong_id' => $phong->id,
            'ghi_chu' => "Ky {$thang}/{$nam}",
            'trang_thai' => InvoiceStatus::Paid,
            'ngay_thanh_toan' => now()->toDateString(),
            'loai_hoadon' => 'monthly',
        ]);

        $data = [
            'phong_id' => $phong->id,
            'thang' => $thang,
            'nam' => $nam,
            'chisodiencu' => 200,
            'chisodienmoi' => 250,
            'chisonuoccu' => 100,
            'chisonuocmoi' => 110,
        ];

        $service = app(HoadonServiceInterface::class);
        $result = $service->xuLyHoaDon($data);

        $this->assertEquals('loi', $result['toast_loai']);
        $this->assertStringContainsString('đã', $result['toast_noidung']);
    }


    public function test_hoa_don_qua_han()
    {
        $hoadon = Hoadon::factory()->create([
            'trang_thai' => InvoiceStatus::Unpaid,
            'ngay_het_han' => now()->subDays(1)->toDateString(),
        ]);

        $this->artisan('hoadon:kiem-tra-qua-han');

        $this->assertEquals(InvoiceStatus::Overdue, $hoadon->fresh()->trang_thai);
    }
}
