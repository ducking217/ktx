<?php

namespace Tests\Unit\Services;

use App\Services\Admin\BaoCaoService;
use App\Enums\BedStatus;
use App\Enums\InvoiceStatus;
use App\Models\Giuong;
use App\Models\Hoadon;
use App\Models\Phong;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class BaoCaoServiceTest extends TestCase
{
    use RefreshDatabase;

    private BaoCaoService $baoCaoService;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        $this->baoCaoService = new BaoCaoService();
    }

    public function test_tinh_doanh_thu_theo_thang_dung()
    {
        $nam = 2026;

        $phong = Phong::factory()->create();
        Hoadon::factory()->create([
            'phong_id' => $phong->id,
            'trang_thai' => InvoiceStatus::Paid,
            'ngay_thanh_toan' => "{$nam}-01-10",
            'tong_tien' => 5000000,
        ]);
        Hoadon::factory()->create([
            'phong_id' => $phong->id,
            'trang_thai' => InvoiceStatus::Paid,
            'ngay_thanh_toan' => "{$nam}-02-10",
            'tong_tien' => 3000000,
        ]);
        Hoadon::factory()->create([
            'phong_id' => $phong->id,
            'trang_thai' => InvoiceStatus::Unpaid,
            'ngay_thanh_toan' => null,
            'tong_tien' => 9999999,
        ]);

        $result = $this->baoCaoService->layDuLieuTaiChinh($nam);

        $this->assertSame(5000000, (int) $result['doanhThuTheoThang']->firstWhere('thang', 1)->tong);
        $this->assertSame(3000000, (int) $result['doanhThuTheoThang']->firstWhere('thang', 2)->tong);
    }

    public function test_ty_le_lap_day_tinh_dung()
    {
        $nam = 2026;
        Cache::flush();

        $phongTrong = Phong::factory()->create();
        $phongDangThue = Phong::factory()->create();
        Giuong::factory()->create([
            'phong_id' => $phongDangThue->id,
            'trang_thai' => BedStatus::Occupied,
        ]);

        $result = $this->baoCaoService->layDuLieuTaiChinh($nam);
        $this->assertSame(50.0, (float) $result['tyLeLapDay']);
    }

    public function test_khong_tinh_hoa_don_chua_thanh_toan()
    {
        $nam = 2026;
        Cache::flush();

        $phong = Phong::factory()->create();

        Hoadon::factory()->create([
            'phong_id' => $phong->id,
            'trang_thai' => InvoiceStatus::Paid,
            'ngay_thanh_toan' => "{$nam}-05-10",
            'tong_tien' => 2000000,
        ]);
        Hoadon::factory()->create([
            'phong_id' => $phong->id,
            'trang_thai' => InvoiceStatus::Unpaid,
            'ngay_thanh_toan' => null,
            'tong_tien' => 7777777,
        ]);

        $result = $this->baoCaoService->layDuLieuTaiChinh($nam);
        $this->assertSame(2000000, (int) $result['doanhThuTheoThang']->firstWhere('thang', 5)->tong);
    }

    public function test_top_phong_tra_ve_dung_so_luong()
    {
        $nam = 2026;
        Cache::flush();

        $phong1 = Phong::factory()->create();
        $phong2 = Phong::factory()->create();
        $phong3 = Phong::factory()->create();

        Hoadon::factory()->create([
            'phong_id' => $phong1->id,
            'trang_thai' => InvoiceStatus::Paid,
            'ngay_thanh_toan' => "{$nam}-05-10",
            'tong_tien' => 5000,
        ]);
        Hoadon::factory()->create([
            'phong_id' => $phong2->id,
            'trang_thai' => InvoiceStatus::Paid,
            'ngay_thanh_toan' => "{$nam}-05-10",
            'tong_tien' => 4000,
        ]);
        Hoadon::factory()->create([
            'phong_id' => $phong3->id,
            'trang_thai' => InvoiceStatus::Paid,
            'ngay_thanh_toan' => "{$nam}-05-10",
            'tong_tien' => 3000,
        ]);

        $result = $this->baoCaoService->layDuLieuTaiChinh($nam);

        $this->assertCount(3, $result['topPhong']);
        $this->assertSame(5000, (int) $result['topPhong']->first()->tong);
        $this->assertSame(3000, (int) $result['topPhong']->last()->tong);
    }
}
