<?php

namespace Tests\Unit\Services;

use App\Contracts\Admin\HoanTienServiceInterface;
use App\Contracts\Admin\HopdongServiceInterface;
use App\Enums\ContractStatus;
use App\Enums\RegistrationStatus;
use App\Enums\UserRole;
use App\Mail\DangkyDaDuyetMail;
use App\Models\Dangky;
use App\Models\Giuong;
use App\Models\LoaiPhong;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\ToaNha;
use App\Models\User;
use App\Services\Admin\DangkyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class DangkyServiceTest extends TestCase
{
    use RefreshDatabase;

    private DangkyService $dangkyService;
    private HoanTienServiceInterface&MockInterface $hoanTienService;
    private HopdongServiceInterface&MockInterface $hopdongService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->hoanTienService = Mockery::mock(HoanTienServiceInterface::class);
        $this->hopdongService = Mockery::mock(HopdongServiceInterface::class);
        $this->dangkyService = new DangkyService($this->hoanTienService, $this->hopdongService);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_duyet_dang_ky_tao_hop_dong_va_gui_mail(): void
    {
        Mail::fake();

        $toaNha = ToaNha::factory()->create();
        $loaiPhong = LoaiPhong::factory()->create();
        $phong = Phong::factory()->create([
            'toa_nha_id' => $toaNha->id,
            'loai_phong_id' => $loaiPhong->id,
        ]);
        $giuong = Giuong::factory()->create([
            'phong_id' => $phong->id,
            'trang_thai' => \App\Enums\BedStatus::Available,
        ]);

        $user = User::factory()->create([
            'vaitro' => UserRole::Student,
            'email' => 'sv@example.com',
        ]);
        $sinhvien = Sinhvien::factory()->create(['user_id' => $user->id]);

        $dangky = Dangky::query()->create([
            'user_id' => $user->id,
            'toa_nha_id' => $toaNha->id,
            'loai_phong_id' => $loaiPhong->id,
            'phong_id' => $phong->id,
            'trang_thai' => RegistrationStatus::Pending->value,
            'lookup_token' => Str::random(32),
        ]);

        $ngayHetHan = now()->addMonths(6)->format('Y-m-d');
        $result = $this->dangkyService->duyetDangKy($dangky->id, $ngayHetHan);

        $this->assertEquals('thanhcong', $result['toast_loai']);
        $this->assertDatabaseHas('hopdong', [
            'sinhvien_id' => $sinhvien->id,
            'phong_id' => $giuong->phong_id,
            'giuong_id' => $giuong->id,
            'trang_thai' => ContractStatus::Active->value,
        ]);

        Mail::assertQueued(DangkyDaDuyetMail::class);
    }

    public function test_khong_cho_phep_gui_dang_ky_khi_da_gui_don_cho_duyet(): void
    {
        $user = User::factory()->create(['vaitro' => UserRole::Student]);
        Sinhvien::factory()->create(['user_id' => $user->id]);
        $phong = Phong::factory()->create();

        Dangky::query()->create([
            'user_id' => $user->id,
            'phong_id' => $phong->id,
            'toa_nha_id' => $phong->toa_nha_id,
            'loai_phong_id' => $phong->loai_phong_id,
            'trang_thai' => RegistrationStatus::Pending->value,
            'lookup_token' => Str::random(32),
        ]);

        $this->actingAs($user);
        $result = $this->dangkyService->luuDangKySinhVien(['phong_id' => $phong->id]);

        $this->assertEquals('loi', $result['toast_loai']);
        $this->assertEquals('Bạn đã gửi đăng ký, vui lòng chờ admin xử lý.', $result['toast_noidung']);
    }
}
