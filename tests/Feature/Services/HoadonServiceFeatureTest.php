<?php

namespace Tests\Feature\Services;

use App\Enums\InvoiceStatus;
use App\Models\Hoadon;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\ToaNha;
use App\Models\User;
use App\Services\Admin\HoadonService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HoadonServiceFeatureTest extends TestCase
{
    use RefreshDatabase;

    private HoadonService $hoadonService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->hoadonService = new HoadonService();
    }

    /**
     * test_xu_ly_hoa_don_thanh_cong
     */
    public function test_xu_ly_hoa_don_thanh_cong(): void
    {
        $toaNha = ToaNha::factory()->create();
        $phong = Phong::factory()->create([
            'toa_nha_id' => $toaNha->id,
            'giaphong' => 500000,
            'succhuamax' => 4,
            'dango' => 2
        ]);

        $data = [
            'phong_id' => $phong->id,
            'thang' => 5,
            'nam' => 2026,
            'chisodiencu' => 100,
            'chisodienmoi' => 110,
            'chisonuoccu' => 50,
            'chisonuocmoi' => 53,
        ];

        // Action
        $result = $this->hoadonService->xuLyHoaDon($data);

        // Assert
        $this->assertEquals('thanhcong', $result['toast_loai']);
        $this->assertDatabaseHas('hoadon', [
            'phong_id' => $phong->id,
            'thang' => 5,
            'nam' => 2026,
            'chisodiencu' => 100,
            'chisodienmoi' => 110,
            'chisonuoccu' => 50,
            'chisonuocmoi' => 53,
            'tienphong' => 500000,
            'trangthaithanhtoan' => InvoiceStatus::Pending->value,
        ]);

        $hoadon = Hoadon::where('phong_id', $phong->id)->first();
        // Tiền điện = (110-100) * 3500 = 35000
        // Tiền nước = (53-50) * 15000 = 45000
        // Phí dịch vụ = 50000 (mặc định)
        // Tổng = 500000 + 35000 + 45000 + 50000 = 630000
        $this->assertEquals(630000, $hoadon->tongtien);
    }

    /**
     * test_khong_cho_phep_ghi_de_hoa_don_da_thanh_toan
     */
    public function test_khong_cho_phep_ghi_de_hoa_don_da_thanh_toan(): void
    {
        $toaNha = ToaNha::factory()->create();
        $phong = Phong::factory()->create(['toa_nha_id' => $toaNha->id]);
        
        Hoadon::factory()->create([
            'phong_id' => $phong->id,
            'thang' => 5,
            'nam' => 2026,
            'trangthaithanhtoan' => InvoiceStatus::Paid
        ]);

        $data = [
            'phong_id' => $phong->id,
            'thang' => 5,
            'nam' => 2026,
            'chisodiencu' => 110,
            'chisodienmoi' => 120,
            'chisonuoccu' => 53,
            'chisonuocmoi' => 55,
        ];

        $result = $this->hoadonService->xuLyHoaDon($data);

        $this->assertEquals('loi', $result['toast_loai']);
        $this->assertStringContainsString('đã được thanh toán', $result['toast_noidung']);
    }
}
