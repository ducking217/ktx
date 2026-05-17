<?php

namespace Tests\Unit\Services;

use App\Contracts\Core\KiemToanServiceInterface;
use App\Enums\BedStatus;
use App\Services\Shared\SinhvienService;
use App\Enums\ContractStatus;
use App\Models\Giuong;
use App\Models\LoaiPhong;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class SinhvienServiceTest extends TestCase
{
    use RefreshDatabase;

    private SinhvienService $sinhvienService;
    private KiemToanServiceInterface&MockInterface $kiemToanService;

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

    public function test_assign_room_tao_hopdong_moi(): void
    {
        $this->kiemToanService->shouldReceive('ghiNhatKy')->once();

        $loaiPhong = LoaiPhong::factory()->create(['gia_thang' => 1000000]);
        $phong = Phong::factory()->create(['loai_phong_id' => $loaiPhong->id]);
        $giuong = Giuong::factory()->create([
            'phong_id' => $phong->id,
            'trang_thai' => BedStatus::Available,
        ]);
        $user = User::factory()->create();
        $sinhvien = Sinhvien::factory()->create(['user_id' => $user->id]);

        $result = $this->sinhvienService->assignRoom($sinhvien->id, $phong->id);

        $this->assertEquals('thanhcong', $result['toast_loai']);
        $this->assertStringContainsString('Xếp phòng thành công', $result['toast_noidung']);
        $this->assertDatabaseHas('hopdong', [
            'sinhvien_id' => $sinhvien->id,
            'phong_id' => $phong->id,
            'giuong_id' => $giuong->id,
            'trang_thai' => ContractStatus::Active->value,
        ]);
        $this->assertEquals(BedStatus::Occupied->value, $giuong->fresh()->trang_thai->value);
    }

    public function test_assign_room_bao_loi_khi_phong_khong_ton_tai(): void
    {
        $user = User::factory()->create();
        $sinhvien = Sinhvien::factory()->create(['user_id' => $user->id]);
        $result = $this->sinhvienService->assignRoom($sinhvien->id, 999999);

        $this->assertEquals('loi', $result['toast_loai']);
        $this->assertEquals('Phòng không tồn tại.', $result['toast_noidung']);
    }
}
