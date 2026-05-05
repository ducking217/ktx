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
        $phong = Phong::factory()->create();

        // Seed: tạo 3 Hoadon paid trong tháng 1/2026 (tổng 9tr)
        // Lưu ý: tổng_tiền phải bằng sum các thành phần để pass check constraint
        $tienMoiHoadon = 3000000;
        Hoadon::factory()->count(3)->create([
            'phong_id' => $phong->id,
            'tien_phong' => $tienMoiHoadon,
            'tien_dien' => 0,
            'tien_nuoc' => 0,
            'phi_dich_vu' => 0,
            'tong_tien' => $tienMoiHoadon,
            'trang_thai' => InvoiceStatus::Paid,
            'ngay_thanh_toan' => Carbon::parse('2026-01-10'),
        ]);

        // Seed: tạo 2 Hoadon unpaid trong tháng 1/2026 (không tính)
        Hoadon::factory()->count(2)->create([
            'phong_id' => $phong->id,
            'trang_thai' => InvoiceStatus::Unpaid,
            'ngay_thanh_toan' => null,
        ]);

        $data = $this->baoCaoService->layDuLieuTaiChinh();
        $doanhThu = $data['doanhThuTheoThang'];

        // Kiểm tra tháng 1 (trong kết quả truy vấn group by month/year)
        $thang1 = $doanhThu->firstWhere('thang', 1);
        $this->assertNotNull($thang1);
        $this->assertEquals(9000000, (float) $thang1->tong);
        
        $this->assertCount(1, $doanhThu);
    }

    /**
     * test_ty_le_lap_day_tinh_theo_so_phong_co_sinhvien
     */
    public function test_ty_le_lap_day_tinh_theo_so_phong_co_sinhvien(): void
    {
        // 7 phòng có người (Giuong có trạng thái Occupied)
        for ($i = 0; $i < 7; $i++) {
            $phong = Phong::factory()->create();
            \App\Models\Giuong::factory()->create([
                'phong_id' => $phong->id,
                'trang_thai' => \App\Enums\BedStatus::Occupied
            ]);
        }
        
        // 3 phòng trống (Giuong có trạng thái Available)
        for ($i = 0; $i < 3; $i++) {
            $phong = Phong::factory()->create();
            \App\Models\Giuong::factory()->create([
                'phong_id' => $phong->id,
                'trang_thai' => \App\Enums\BedStatus::Available
            ]);
        }

        $data = $this->baoCaoService->layDuLieuTaiChinh();
        
        // Assert: tyLeLapDay() trả về 70.0 (7/10 * 100)
        $this->assertEquals(70.0, $data['tyLeLapDay']);
    }

    /**
     * test_chi_tinh_hoa_don_da_thanh_toan
     */
    public function test_chi_tinh_hoa_don_da_thanh_toan(): void
    {
        $phong = Phong::factory()->create();

        // 1 Hoadon paid (5tr) - tính vào doanh thu tháng này
        $tienPaid = 5000000;
        Hoadon::factory()->create([
            'phong_id' => $phong->id,
            'tien_phong' => $tienPaid,
            'tien_dien' => 0,
            'tien_nuoc' => 0,
            'phi_dich_vu' => 0,
            'tong_tien' => $tienPaid,
            'trang_thai' => InvoiceStatus::Paid,
            'ngay_thanh_toan' => Carbon::parse('2026-01-10')
        ]);

        // 1 Hoadon unpaid (3tr) - không tính
        Hoadon::factory()->create([
            'phong_id' => $phong->id,
            'trang_thai' => InvoiceStatus::Unpaid,
            'ngay_thanh_toan' => null,
        ]);

        // 1 Hoadon overdue (2tr) - không tính
        Hoadon::factory()->create([
            'phong_id' => $phong->id,
            'trang_thai' => InvoiceStatus::Overdue,
            'ngay_thanh_toan' => null,
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
        $phongA = Phong::factory()->create(['ten_phong' => 'A']);
        $phongB = Phong::factory()->create(['ten_phong' => 'B']);
        $phongC = Phong::factory()->create(['ten_phong' => 'C']);

        // phong A = 10tr
        $tienA = 10000000;
        Hoadon::factory()->create([
            'phong_id' => $phongA->id,
            'tien_phong' => $tienA,
            'tien_dien' => 0,
            'tien_nuoc' => 0,
            'phi_dich_vu' => 0,
            'tong_tien' => $tienA,
            'trang_thai' => InvoiceStatus::Paid,
            'ngay_thanh_toan' => Carbon::parse('2026-01-10'),
        ]);

        // phong B = 5tr
        $tienB = 5000000;
        Hoadon::factory()->create([
            'phong_id' => $phongB->id,
            'tien_phong' => $tienB,
            'tien_dien' => 0,
            'tien_nuoc' => 0,
            'phi_dich_vu' => 0,
            'tong_tien' => $tienB,
            'trang_thai' => InvoiceStatus::Paid,
            'ngay_thanh_toan' => Carbon::parse('2026-01-10'),
        ]);

        // phong C = 8tr
        $tienC = 8000000;
        Hoadon::factory()->create([
            'phong_id' => $phongC->id,
            'tien_phong' => $tienC,
            'tien_dien' => 0,
            'tien_nuoc' => 0,
            'phi_dich_vu' => 0,
            'tong_tien' => $tienC,
            'trang_thai' => InvoiceStatus::Paid,
            'ngay_thanh_toan' => Carbon::parse('2026-01-10'),
        ]);

        $data = $this->baoCaoService->layDuLieuTaiChinh();
        $topPhong = $data['topPhong'];

        // Assert: thứ tự trả về là A (10tr), C (8tr), B (5tr)
        // Lưu ý: Trong BaoCaoService v2, topPhong trả về list objects có {phong_id, tong}
        $this->assertCount(3, $topPhong);
        $this->assertEquals($phongA->id, $topPhong[0]->phong_id);
        $this->assertEquals(10000000, (float) $topPhong[0]->tong);
        $this->assertEquals($phongC->id, $topPhong[1]->phong_id);
        $this->assertEquals(8000000, (float) $topPhong[1]->tong);
        $this->assertEquals($phongB->id, $topPhong[2]->phong_id);
        $this->assertEquals(5000000, (float) $topPhong[2]->tong);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow(); // Reset thời gian
        parent::tearDown();
    }
}
