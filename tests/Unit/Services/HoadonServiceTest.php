<?php

namespace Tests\Unit\Services;

use App\Services\Admin\HoadonService;
use App\Enums\InvoiceStatus;
use App\Models\Hoadon;
use App\Models\Phong;
use App\Models\Sinhvien;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HoadonServiceTest extends TestCase
{
    use RefreshDatabase;

    private HoadonService $hoadonService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->hoadonService = new HoadonService();
    }

    public function test_tinh_tong_tien_bao_gom_phi_dich_vu(): void
    {
        $phong = Phong::factory()->create();
        $sinhvien = Sinhvien::factory()->create();
        $giuong = \App\Models\Giuong::factory()->create(['phong_id' => $phong->id]);
        \App\Models\Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien->id,
            'giuong_id' => $giuong->id,
            'phong_id' => $phong->id,
            'trang_thai' => \App\Enums\ContractStatus::Active,
            'gia_thuc_te' => 500000,
        ]);

        $result = $this->hoadonService->xuLyHoaDon([
            'phong_id' => $phong->id,
            'thang' => 5,
            'nam' => 2026,
            'chisodiencu' => 100,
            'chisodienmoi' => 110,
            'chisonuoccu' => 50,
            'chisonuocmoi' => 53,
        ]);

        $this->assertEquals('thanhcong', $result['toast_loai']);

        $hoadon = Hoadon::where('phong_id', $phong->id)->first();
        $this->assertNotNull($hoadon);
        $this->assertEquals(630000, $hoadon->tong_tien);
    }

    public function test_paid_guard_khong_cho_phep_ghi_de_hoa_don_da_thanh_toan(): void
    {
        $phong = Phong::factory()->create();
        $hopdong = \App\Models\Hopdong::factory()->create(['phong_id' => $phong->id]);

        Hoadon::factory()->create([
            'hopdong_id' => $hopdong->id,
            'phong_id' => $phong->id,
            'trang_thai' => InvoiceStatus::Paid,
            'ngay_thanh_toan' => now()->toDateString(),
            'ghi_chu' => "Ky 5/2026",
            'loai_hoadon' => 'monthly',
        ]);

        $result = $this->hoadonService->xuLyHoaDon([
            'phong_id' => $phong->id,
            'thang' => 5,
            'nam' => 2026,
            'chisodiencu' => 110,
            'chisodienmoi' => 120,
            'chisonuoccu' => 53,
            'chisonuocmoi' => 55,
        ]);

        $this->assertEquals('loi', $result['toast_loai']);
        $this->assertStringContainsString('đã được thanh toán', $result['toast_noidung']);
    }
}
