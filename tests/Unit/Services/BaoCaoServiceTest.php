<?php

namespace Tests\Unit\Services;

use App\Enums\InvoiceStatus;
use App\Services\Admin\BaoCaoService;
use Mockery;
use PHPUnit\Framework\TestCase;

class BaoCaoServiceTest extends TestCase
{
    private $baoCaoService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->baoCaoService = new BaoCaoService();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_tinh_doanh_thu_theo_thang_dung()
    {
        $mockData = collect([
            (object)['thang' => 1, 'nam' => 2026, 'tong' => 5000000, 'so_luong' => 5],
            (object)['thang' => 2, 'nam' => 2026, 'tong' => 3000000, 'so_luong' => 3],
        ]);

        $hoadonMock = Mockery::mock('overload:App\Models\Hoadon');
        
        $hoadonMock->shouldReceive('selectRaw->where->whereNotNull->where->groupBy->orderBy->orderBy->get')
            ->andReturn($mockData);
        
        $hoadonMock->shouldReceive('where->where->sum')->andReturn(1000000);
        $hoadonMock->shouldReceive('with->selectRaw->where->groupBy->orderByDesc->limit->get')->andReturn(collect());
        $hoadonMock->shouldReceive('where->where->where->sum')->andReturn(5000000);

        $phongMock = Mockery::mock('overload:App\Models\Phong');
        $phongMock->shouldReceive('count')->andReturn(100);
        $phongMock->shouldReceive('where->count')->andReturn(75);

        $result = $this->baoCaoService->layDuLieuTaiChinh();
        
        $this->assertEquals($mockData, $result['doanhThuTheoThang']);
        $this->assertEquals(5000000, $result['doanhThuTheoThang']->firstWhere('thang', 1)->tong);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_ty_le_lap_day_tinh_dung()
    {
        $hoadonMock = Mockery::mock('overload:App\Models\Hoadon');
        
        $hoadonMock->shouldReceive('selectRaw->where->whereNotNull->where->groupBy->orderBy->orderBy->get')->andReturn(collect());
        $hoadonMock->shouldReceive('where->where->sum')->andReturn(0);
        $hoadonMock->shouldReceive('with->selectRaw->where->groupBy->orderByDesc->limit->get')->andReturn(collect());
        $hoadonMock->shouldReceive('where->where->where->sum')->andReturn(0);

        $phongMock = Mockery::mock('overload:App\Models\Phong');
        $phongMock->shouldReceive('count')->andReturn(100);
        $phongMock->shouldReceive('where->count')->andReturn(75);

        $result = $this->baoCaoService->layDuLieuTaiChinh();

        $this->assertEquals(75.0, $result['tyLeLapDay']);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_khong_tinh_hoa_don_chua_thanh_toan()
    {
        $paidData = collect([(object)['thang' => 5, 'nam' => 2026, 'tong' => 2000000, 'so_luong' => 1]]);

        $hoadonMock = Mockery::mock('overload:App\Models\Hoadon');

        // Main chart query
        $hoadonMock->shouldReceive('selectRaw->where->whereNotNull->where->groupBy->orderBy->orderBy->get')
            ->andReturn($paidData);

        // Deposit query
        $hoadonMock->shouldReceive('where')->with('loai_hoadon', Mockery::any())->andReturnSelf();
        $hoadonMock->shouldReceive('where')->with('trangthaithanhtoan', InvoiceStatus::Paid->value)->andReturnSelf();
        $hoadonMock->shouldReceive('sum')->with('tongtien')->andReturn(1000000);

        // Top rooms
        $hoadonMock->shouldReceive('with->selectRaw->where->groupBy->orderByDesc->limit->get')->andReturn(collect());
        
        // Month comparison queries
        $hoadonMock->shouldReceive('where')->with('thang', Mockery::any())->andReturnSelf();
        $hoadonMock->shouldReceive('where')->with('nam', Mockery::any())->andReturnSelf();

        $phongMock = Mockery::mock('overload:App\Models\Phong');
        $phongMock->shouldReceive('count')->andReturn(0);
        $phongMock->shouldReceive('where->count')->andReturn(0);

        $result = $this->baoCaoService->layDuLieuTaiChinh();

        $this->assertEquals(2000000, $result['doanhThuTheoThang']->firstWhere('thang', 5)->tong);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_top_phong_tra_ve_dung_so_luong()
    {
        $topPhongData = collect([
            (object)['phong_id' => 1, 'tong' => 5000],
            (object)['phong_id' => 2, 'tong' => 4000],
            (object)['phong_id' => 3, 'tong' => 3000],
        ]);

        $hoadonMock = Mockery::mock('overload:App\Models\Hoadon');

        $hoadonMock->shouldReceive('selectRaw->where->whereNotNull->where->groupBy->orderBy->orderBy->get')->andReturn(collect());
        $hoadonMock->shouldReceive('where->where->sum')->andReturn(0);
        $hoadonMock->shouldReceive('where->where->where->sum')->andReturn(0);
        
        // Specifically mock the top rooms query
        $topQueryMock = Mockery::mock('TopQuery');
        $hoadonMock->shouldReceive('with')->with('phong')->andReturn($topQueryMock);
        $topQueryMock->shouldReceive('selectRaw')->with('phong_id, SUM(tongtien) as tong')->andReturnSelf();
        $topQueryMock->shouldReceive('where')->with('trangthaithanhtoan', InvoiceStatus::Paid->value)->andReturnSelf();
        $topQueryMock->shouldReceive('groupBy')->with('phong_id')->andReturnSelf();
        $topQueryMock->shouldReceive('orderByDesc')->with('tong')->andReturnSelf();
        $topQueryMock->shouldReceive('limit')->with(5)->andReturnSelf();
        $topQueryMock->shouldReceive('get')->andReturn($topPhongData);

        $phongMock = Mockery::mock('overload:App\Models\Phong');
        $phongMock->shouldReceive('count')->andReturn(0);
        $phongMock->shouldReceive('where->count')->andReturn(0);

        $result = $this->baoCaoService->layDuLieuTaiChinh();

        $this->assertCount(3, $result['topPhong']);
        $this->assertEquals(5000, $result['topPhong']->first()->tong);
        $this->assertEquals(3000, $result['topPhong']->last()->tong);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
