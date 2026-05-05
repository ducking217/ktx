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
        $phong = Phong::factory()->create();
        
        // Cần có sinh viên có hợp đồng active trong phòng để tạo hóa đơn
        $sinhvien = Sinhvien::factory()->create();
        $giuong = \App\Models\Giuong::factory()->create(['phong_id' => $phong->id]);
        \App\Models\Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien->id,
            'giuong_id' => $giuong->id,
            'phong_id' => $phong->id,
            'trang_thai' => \App\Enums\ContractStatus::Active,
            'gia_thuc_te' => 500000
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
        
        $hoadon = Hoadon::where('phong_id' , $phong->id)->first();
        $this->assertNotNull($hoadon);
        $this->assertEquals(InvoiceStatus::Unpaid, $hoadon->trang_thai);
        
        // Tiền điện = (110-100) * 3500 = 35000
        // Tiền nước = (53-50) * 15000 = 45000
        // Phí dịch vụ = 50000 (mặc định)
        // Tiền phòng thực tế từ hợp đồng = 500000
        // Tổng = 500000 + 35000 + 45000 + 50000 = 630000
        $this->assertEquals(630000, $hoadon->tong_tien);
    }

    /**
     * test_khong_cho_phep_ghi_de_hoa_don_da_thanh_toan
     */
    public function test_khong_cho_phep_ghi_de_hoa_don_da_thanh_toan(): void
    {
        $phong = Phong::factory()->create();
        
        $hopdong = \App\Models\Hopdong::factory()->create(['phong_id' => $phong->id]);
        
        $status = InvoiceStatus::Paid;
        Hoadon::factory()->create([
            'hopdong_id' => $hopdong->id,
            'phong_id' => $phong->id,
            'trang_thai' => $status,
            'ngay_thanh_toan' => now()->toDateString(),
            'ghi_chu' => "Ky " . now()->month . "/" . now()->year
        ]);

        $data = [
            'phong_id' => $phong->id,
            'thang' => now()->month,
            'nam' => now()->year,
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
