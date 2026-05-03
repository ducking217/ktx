<?php

namespace Tests\Unit\Services;

use App\Services\Admin\DangkyService;
use App\Models\Dangky;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Enums\RegistrationStatus;
use App\Mail\DangkyDaDuyetMail;
use App\Contracts\Admin\HoanTienServiceInterface;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class DangkyServiceTest extends TestCase
{
    private $dangkyService;
    private $hoanTienService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->hoanTienService = Mockery::mock(HoanTienServiceInterface::class);
        $this->dangkyService = new DangkyService($this->hoanTienService);
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
    public function test_gui_mail_sau_khi_duyet_dang_ky()
    {
        Mail::fake();

        $dangky = Mockery::mock('alias:App\Models\Dangky');
        $dangkyModel = Mockery::mock(\App\Models\Dangky::class)->makePartial();
        $dangkyModel->id = 1;
        $dangkyModel->email = 'test@example.com';
        
        $dangky->shouldReceive('find')->with(1)->andReturn($dangkyModel);
        
        // Giả lập transitionTo thành công
        $dangkyModel->shouldReceive('transitionTo')->andReturn(true);

        $this->dangkyService->duyetDangKy(1);

        // Kiểm tra xem mail có được đưa vào queue không (tùy vào logic thực tế là send hay queue)
        Mail::assertSent(DangkyDaDuyetMail::class);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_khong_cho_dang_ky_khi_phong_da_day()
    {
        // Mock Auth
        \Illuminate\Support\Facades\Auth::shouldReceive('id')->andReturn(1);

        // Mock Sinhvien
        $sinhvien = Mockery::mock('alias:App\Models\Sinhvien');
        $svModel = new \App\Models\Sinhvien();
        $svModel->id = 1;
        $svModel->phong_id = null;
        $sinhvien->shouldReceive('where->first')->andReturn($svModel);
        $sinhvien->shouldReceive('where->count')->andReturn(8); // Giả lập phòng đã có 8 người

        // Mock Phong
        $phong = Mockery::mock('alias:App\Models\Phong');
        $phongModel = new \App\Models\Phong();
        $phongModel->id = 101;
        $phongModel->succhuamax = 8;
        $phong->shouldReceive('where->lockForUpdate->first')->andReturn($phongModel);

        // Mock DB Transaction
        DB::shouldReceive('transaction')->andReturnUsing(function ($callback) {
            return $callback();
        });

        $data = ['phong_id' => 101];
        $result = $this->dangkyService->luuDangKySinhVien($data);

        $this->assertEquals('loi', $result['toast_loai']);
        $this->assertEquals('Phòng đã đầy hoặc đang có người khác đăng ký, vui lòng thử lại.', $result['toast_noidung']);
    }
}
