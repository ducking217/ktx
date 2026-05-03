<?php

namespace Tests\Feature\Services;

use App\Enums\InvoiceStatus;
use App\Models\Hoadon;
use App\Models\Phong;
use App\Models\ToaNha;
use App\Services\Admin\BaoCaoService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BaoCaoServiceFeatureTest extends TestCase
{
    use RefreshDatabase;

    private BaoCaoService $baoCaoService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->baoCaoService = new BaoCaoService();
        // Cố định thời gian test là 15/01/2026
        Carbon::setTestNow('2026-01-15');
    }

    /**
     * test_tinh_doanh_thu_theo_thang_chinh_xac
     */
    public function test_tinh_doanh_thu_theo_thang_chinh_xac(): void
    {
        $toaNha = ToaNha::factory()->create();
        $phong = Phong::factory()->create(['toa_nha_id' => $toaNha->id]);

        // Seed: tạo 3 Hoadon paid trong tháng 1/2026 (tổng 9tr)
        Hoadon::factory()->count(3)->create([
            'phong_id' => $phong->id,
            'tongtien' => 3000000,
            'trangthaithanhtoan' => InvoiceStatus::Paid,
            'ngay_thanh_toan' => Carbon::parse('2026-01-10'),
            'thang' => 1,
            'nam' => 2026
        ]);

        // Seed: tạo 2 Hoadon pending trong tháng 1/2026 (không tính)
        Hoadon::factory()->count(2)->create([
            'phong_id' => $phong->id,
            'tongtien' => 3000000,
            'trangthaithanhtoan' => InvoiceStatus::Pending,
            'ngay_thanh_toan' => null,
            'thang' => 1,
            'nam' => 2026
        ]);

        $data = $this->baoCaoService->layDuLieuTaiChinh();
        $doanhThu = $data['doanhThuTheoThang'];

        // Kiểm tra tháng 1 (trong kết quả truy vấn group by month/year)
        $thang1 = $doanhThu->firstWhere('thang', 1);
        $this->assertNotNull($thang1);
        $this->assertEquals(9000000, (float) $thang1->tong);
        
        // Do query lấy 12 tháng gần nhất, nếu chỉ seed tháng 1 thì count doanh thu các tháng khác nên là 0 hoặc không tồn tại
        $this->assertCount(1, $doanhThu);
    }

    /**
     * test_ty_le_lap_day_tinh_theo_so_phong_co_sinhvien
     */
    public function test_ty_le_lap_day_tinh_theo_so_phong_co_sinhvien(): void
    {
        $toaNha = ToaNha::factory()->create();
        
        // Seed: tạo 10 Phong
        // 7 phòng có người (dango > 0)
        Phong::factory()->count(7)->create([
            'toa_nha_id' => $toaNha->id,
            'dango' => 1
        ]);
        // 3 phòng trống
        Phong::factory()->count(3)->create([
            'toa_nha_id' => $toaNha->id,
            'dango' => 0
        ]);

        $data = $this->baoCaoService->layDuLieuTaiChinh();
        
        // Assert: tyLeLapDay() trả về 70.0 (7/10 * 100)
        $this->assertEquals(70.0, $data['tyLeLapDay']);
    }

    /**
     * test_chi_tinh_hoa_don_da_thanh_toan
     */
    public function test_chi_tinh_hoa_don_da_thanh_toan(): void
    {
        $toaNha = ToaNha::factory()->create();
        $phong = Phong::factory()->create(['toa_nha_id' => $toaNha->id]);

        // 1 Hoadon paid (5tr) - tính vào doanh thu tháng này
        Hoadon::factory()->create([
            'phong_id' => $phong->id,
            'tongtien' => 5000000,
            'trangthaithanhtoan' => InvoiceStatus::Paid,
            'thang' => 1,
            'nam' => 2026,
            'ngay_thanh_toan' => Carbon::parse('2026-01-10')
        ]);

        // 1 Hoadon pending (3tr) - không tính
        Hoadon::factory()->create([
            'phong_id' => $phong->id,
            'tongtien' => 3000000,
            'trangthaithanhtoan' => InvoiceStatus::Pending,
            'thang' => 1,
            'nam' => 2026
        ]);

        // 1 Hoadon overdue (2tr) - không tính
        Hoadon::factory()->create([
            'phong_id' => $phong->id,
            'tongtien' => 2000000,
            'trangthaithanhtoan' => InvoiceStatus::Overdue,
            'thang' => 1,
            'nam' => 2026
        ]);

        $data = $this->baoCaoService->layDuLieuTaiChinh();
        
        // Assert: tổng doanh thu tháng này = 5.000.000 (chỉ tính paid)
        $this->assertEquals(5000000, $data['doanhThuThangNay']);
    }

    /**
     * test_top_phong_sap_xep_giam_dan
     */
    public function test_top_phong_sap_xep_giam_dan(): void
    {
        $toaNha = ToaNha::factory()->create();
        
        $phongA = Phong::factory()->create(['toa_nha_id' => $toaNha->id, 'tenphong' => 'A']);
        $phongB = Phong::factory()->create(['toa_nha_id' => $toaNha->id, 'tenphong' => 'B']);
        $phongC = Phong::factory()->create(['toa_nha_id' => $toaNha->id, 'tenphong' => 'C']);

        // phong A = 10tr
        Hoadon::factory()->create([
            'phong_id' => $phongA->id,
            'tongtien' => 10000000,
            'trangthaithanhtoan' => InvoiceStatus::Paid
        ]);

        // phong B = 5tr
        Hoadon::factory()->create([
            'phong_id' => $phongB->id,
            'tongtien' => 5000000,
            'trangthaithanhtoan' => InvoiceStatus::Paid
        ]);

        // phong C = 8tr
        Hoadon::factory()->create([
            'phong_id' => $phongC->id,
            'tongtien' => 8000000,
            'trangthaithanhtoan' => InvoiceStatus::Paid
        ]);

        $data = $this->baoCaoService->layDuLieuTaiChinh();
        $topPhong = $data['topPhong'];

        // Assert: thứ tự trả về là A (10tr), C (8tr), B (5tr)
        $this->assertEquals($phongA->id, $topPhong[0]->phong_id);
        $this->assertEquals($phongC->id, $topPhong[1]->phong_id);
        $this->assertEquals($phongB->id, $topPhong[2]->phong_id);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow(); // Reset thời gian
        parent::tearDown();
    }
}
