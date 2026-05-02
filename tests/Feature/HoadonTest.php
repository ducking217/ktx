<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Phong;
use App\Models\Hoadon;
use App\Models\Sinhvien;
use App\Enums\InvoiceStatus;
use App\Enums\UserRole;
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
        $sinhvien = Sinhvien::factory()->create(['phong_id' => $phong->id]);

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
            'thang' => $data['thang'],
            'nam' => $data['nam'],
            'trangthaithanhtoan' => InvoiceStatus::Pending->value,
        ]);
    }

    public function test_thanh_toan_hoa_don()
    {
        $admin = User::factory()->create(['vaitro' => UserRole::Admin]);
        $hoadon = Hoadon::factory()->create(['trangthaithanhtoan' => InvoiceStatus::Pending]);

        $response = $this->actingAs($admin)
            ->post(route('admin.xacnhanthanhtoan', $hoadon->id));

        $response->assertRedirect();
        $this->assertEquals(InvoiceStatus::Paid, $hoadon->fresh()->trangthaithanhtoan);
    }

    public function test_khong_the_ghi_de_hoa_don_da_thanh_toan()
    {
        $phong = Phong::factory()->create();
        $hoadon = Hoadon::factory()->create([
            'phong_id' => $phong->id,
            'thang' => now()->month,
            'nam' => now()->year,
            'trangthaithanhtoan' => InvoiceStatus::Paid,
            'loai_hoadon' => Hoadon::LOAI_MONTHLY
        ]);

        $data = [
            'phong_id' => $phong->id,
            'thang' => $hoadon->thang,
            'nam' => $hoadon->nam,
            'chisodiencu' => 200,
            'chisodienmoi' => 250,
            'chisonuoccu' => 100,
            'chisonuocmoi' => 110,
        ];

        $service = app(HoadonServiceInterface::class);
        $result = $service->xuLyHoaDon($data);

        $this->assertEquals('loi', $result['toast_loai']);
        $this->assertStringContainsString('đã được thanh toán', $result['toast_noidung']);
    }

    public function test_hoa_don_qua_han()
    {
        $hoadon = Hoadon::factory()->create([
            'trangthaithanhtoan' => InvoiceStatus::Pending,
            'created_at' => now()->subDays(31)
        ]);

        $this->artisan('hoadon:kiem-tra-qua-han');

        $this->assertEquals(InvoiceStatus::Overdue, $hoadon->fresh()->trangthaithanhtoan);
    }
}
