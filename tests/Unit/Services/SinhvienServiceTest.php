<?php

namespace Tests\Unit\Services;

use App\Services\Shared\SinhvienService;
use App\Models\Sinhvien;
use App\Models\Phong;
use App\Models\Hopdong;
use App\Contracts\Core\KiemToanServiceInterface;
use App\Enums\ContractStatus;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class SinhvienServiceTest extends TestCase
{
    private $sinhvienService;
    private $kiemToanService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->kiemToanService = Mockery::mock(KiemToanServiceInterface::class);
        $this->sinhvienService = new SinhvienService($this->kiemToanService);
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
    public function test_assign_room_tao_hopdong_moi()
    {
        // Mock DB
        DB::shouldReceive('transaction')->andReturnUsing(function ($callback) {
            return $callback();
        });
        DB::shouldReceive('rollBack')->andReturnNull();

        // Mock Sinhvien
        $sinhvien = Mockery::mock('alias:App\Models\Sinhvien');
        $svModel = Mockery::mock(\App\Models\Sinhvien::class)->makePartial();
        $svModel->id = 1;
        $svModel->phong_id = null;
        $svModel->shouldReceive('update')->andReturn(true);
        $sinhvien->shouldReceive('where->with->lockForUpdate->first')->andReturn($svModel);
        $sinhvien->shouldReceive('where->count')->andReturn(0);

        // Mock Phong
        $phong = Mockery::mock('alias:App\Models\Phong');
        $phongModel = Mockery::mock(\App\Models\Phong::class)->makePartial();
        $phongModel->id = 10;
        $phongModel->succhuamax = 8;
        $phongModel->giaphong = 1000000;
        $phong->shouldReceive('where->lockForUpdate->first')->andReturn($phongModel);
        $phong->shouldReceive('where->update')->andReturn(true);

        // Mock Hopdong
        $hopdong = Mockery::mock('alias:App\Models\Hopdong');
        $hopdong->shouldReceive('where->where->update')->andReturn(true); // terminateActiveContracts
        
        // EXPECTATION: Hopdong::create được gọi
        $hopdong->shouldReceive('create')->once()->with(Mockery::on(function($data) {
            return $data['sinhvien_id'] === 1 && $data['phong_id'] === 10;
        }))->andReturn(new \App\Models\Hopdong());

        // Mock Audit Log
        $this->kiemToanService->shouldReceive('ghiNhatKy')->once();

        $result = $this->sinhvienService->assignRoom(1, 10);

        $this->assertEquals('thanhcong', $result['toast_loai']);
        $this->assertStringContainsString('tạo hợp đồng mới thành công', $result['toast_noidung']);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_assign_room_rollback_khi_co_loi()
    {
        // Mock DB
        DB::shouldReceive('transaction')->andThrow(new \Exception('Lỗi DB ngẫu nhiên'));

        $result = $this->sinhvienService->assignRoom(1, 10);

        $this->assertEquals('loi', $result['toast_loai']);
        $this->assertEquals('Lỗi DB ngẫu nhiên', $result['toast_noidung']);
    }
}
