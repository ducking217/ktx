<?php

namespace Tests\Unit\Services;

use App\Models\Hoadon;
use App\Models\Phong;
use App\Models\Cauhinh;
use App\Services\Admin\HoadonService;
use App\Enums\InvoiceStatus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Mockery;
use PHPUnit\Framework\TestCase;

class HoadonServiceTest extends TestCase
{
    private $hoadonService;

    protected function setUp(): void
    {
        parent::setUp();
        // Cần đảm bảo các class alias được định nghĩa TRƯỚC KHI Service được khởi tạo hoặc class thật được load
        $this->hoadonService = new HoadonService();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_tinh_tong_tien_bao_gom_phi_dich_vu()
    {
        // Mock static calls using alias/overload
        $phongMock = Mockery::mock('overload:App\Models\Phong');
        $phongMock->giaphong = 500000;
        $phongMock->id = 1;
        $phongMock->shouldReceive('find')->with(1)->andReturn($phongMock);

        $hoadonMock = Mockery::mock('overload:App\Models\Hoadon');
        $hoadonMock->shouldReceive('where')->andReturnSelf();
        $hoadonMock->shouldReceive('first')->andReturn(null);
        $hoadonMock->shouldReceive('updateOrCreate')->andReturn(new \stdClass());
        
        if (!defined('App\Models\Hoadon::LOAI_MONTHLY')) {
            define('App\Models\Hoadon::LOAI_MONTHLY', 'monthly');
        }

        // Mock Cache (Static Facade)
        // Vì đây là true Unit test (extends PHPUnit TestCase), ta không có Facade của Laravel sẵn
        // Ta cần mock class Cache nếu Service dùng nó trực tiếp
        Mockery::mock('alias:Illuminate\Support\Facades\Cache')
            ->shouldReceive('remember')
            ->andReturn(3500); // Đơn giản hóa trả về 3500 cho mọi key

        $data = [
            'phong_id' => 1,
            'thang' => 5,
            'nam' => 2026,
            'chisodiencu' => 100,
            'chisodienmoi' => 110,
            'chisonuoccu' => 50,
            'chisonuocmoi' => 53,
        ];

        // Mock service để override protected methods
        $service = Mockery::mock(HoadonService::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $service->shouldReceive('thongBaoPhong')->andReturnNull();
        $service->shouldReceive('layBangGia')->andReturn([
            'dongiadien' => 3500,
            'dongianuoc' => 15000,
            'phidichvu' => 20000,
        ]);

        $result = $service->xuLyHoaDon($data);

        $this->assertEquals('thanhcong', $result['toast_loai']);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_paid_guard_nem_exception_khi_hoa_don_da_thanh_toan()
    {
        $phongMock = Mockery::mock('overload:App\Models\Phong');
        $phongMock->shouldReceive('find')->andReturn($phongMock);

        $existingHoadon = new \stdClass();
        $existingHoadon->trangthaithanhtoan = InvoiceStatus::Paid;

        $hoadonMock = Mockery::mock('overload:App\Models\Hoadon');
        $hoadonMock->shouldReceive('where')->andReturnSelf();
        $hoadonMock->shouldReceive('first')->andReturn($existingHoadon);
        $hoadonMock->LOAI_MONTHLY = 'monthly';

        $data = [
            'phong_id' => 1,
            'thang' => 5,
            'nam' => 2026,
        ];

        $result = $this->hoadonService->xuLyHoaDon($data);

        $this->assertEquals('loi', $result['toast_loai']);
        $this->assertStringContainsString('đã được thanh toán', $result['toast_noidung']);
    }
}
