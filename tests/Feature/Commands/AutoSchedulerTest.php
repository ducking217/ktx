<?php

namespace Tests\Feature\Commands;

use App\Enums\ContractStatus;
use App\Enums\InvoiceStatus;
use App\Mail\CanhBaoHetHanHopDong;
use App\Mail\NhacNoHoaDon;
use App\Models\Hoadon;
use App\Models\Hopdong;
use App\Models\Giuong;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AutoSchedulerTest extends TestCase
{
    use RefreshDatabase;

    private Phong $phong;
    private Giuong $giuong;

    protected function setUp(): void
    {
        parent::setUp();

        $this->phong = Phong::factory()->create()->load('loaiphong');
        $this->giuong = Giuong::factory()->create(['phong_id' => $this->phong->id]);
    }

    private function createStudentWithEmail()
    {
        $user = User::factory()->create([
            'email' => 'student@test.com',
        ]);

        $sinhvien = Sinhvien::factory()->create([
            'user_id' => $user->id,
            'ma_sinh_vien' => 'SV' . str_pad((string) $user->id, 6, '0', STR_PAD_LEFT),
        ]);

        return [$user, $sinhvien];
    }

    /**
     * 1. test_command_chuyen_hopdong_het_han
     */
    public function test_command_chuyen_hopdong_het_han()
    {
        Carbon::setTestNow(now());
        [, $sinhvien] = $this->createStudentWithEmail();

        $hopdong = Hopdong::create([
            'sinhvien_id' => $sinhvien->id,
            'phong_id' => $this->phong->id,
            'giuong_id' => $this->giuong->id,
            'ngay_bat_dau' => now()->subMonths(6),
            'ngay_ket_thuc' => now()->subDay(), // Hết hạn hôm qua
            'trang_thai' => ContractStatus::Active,
            'gia_thuc_te' => (int) ($this->phong->loaiphong?->gia_thang ?? 0),
        ]);

        $this->artisan('hopdong:kiem-tra-het-han')->assertSuccessful();

        $hopdong->refresh();
        $this->assertEquals(ContractStatus::Expired, $hopdong->trang_thai);
    }

    /**
     * 2. test_command_gui_email_canh_bao_30_ngay
     */
    public function test_command_gui_email_canh_bao_30_ngay()
    {
        Mail::fake();
        Carbon::setTestNow(Carbon::create(2026, 5, 1));
        [, $sinhvien] = $this->createStudentWithEmail();

        $hopdong = Hopdong::create([
            'sinhvien_id' => $sinhvien->id,
            'phong_id' => $this->phong->id,
            'giuong_id' => $this->giuong->id,
            'ngay_bat_dau' => now()->subMonths(5),
            'ngay_ket_thuc' => now()->addDays(29), // Rơi vào khoảng Between(28, 30)
            'trang_thai' => ContractStatus::Active,
            'gia_thuc_te' => (int) ($this->phong->loaiphong?->gia_thang ?? 0),
        ]);

        $this->artisan('hopdong:kiem-tra-het-han')->assertSuccessful();

        Mail::assertQueued(CanhBaoHetHanHopDong::class, function ($mail) {
            return $mail->hasTo('student@test.com') && $mail->mocCanhBaoNgay === 30;
        });

        $hopdong->refresh();
        $this->assertEquals(ContractStatus::Active, $hopdong->trang_thai);
    }

    /**
     * 3. test_command_chuyen_hoa_don_qua_han
     */
    public function test_command_chuyen_hoa_don_qua_han()
    {
        Mail::fake();
        Carbon::setTestNow(now());
        [, $sinhvien] = $this->createStudentWithEmail();

        $hopdong = Hopdong::create([
            'sinhvien_id' => $sinhvien->id,
            'phong_id' => $this->phong->id,
            'giuong_id' => $this->giuong->id,
            'ngay_bat_dau' => now()->subMonths(6),
            'ngay_ket_thuc' => now()->addMonths(1),
            'trang_thai' => ContractStatus::Active,
            'gia_thuc_te' => (int) ($this->phong->loaiphong?->gia_thang ?? 0),
        ]);

        $hoadon = Hoadon::create([
            'hopdong_id' => $hopdong->id,
            'phong_id' => $this->phong->id,
            'ma_hoa_don' => 'HD-TEST-OVERDUE-1',
            'loai_hoadon' => Hoadon::LOAI_MONTHLY,
            'tien_phong' => 1500000,
            'tien_dien' => 0,
            'tien_nuoc' => 0,
            'phi_dich_vu' => 0,
            'tong_tien' => 1500000,
            'trang_thai' => InvoiceStatus::Unpaid,
            'ngay_het_han' => now()->subDay(),
            'ngay_thanh_toan' => null,
        ]);

        $this->artisan('hoadon:kiem-tra-qua-han')->assertSuccessful();

        $hoadon->refresh();
        $this->assertEquals(InvoiceStatus::Overdue, $hoadon->trang_thai);
    }

    /**
     * 4. test_command_gui_email_nhac_no
     */
    public function test_command_gui_email_nhac_no()
    {
        Mail::fake();
        Carbon::setTestNow(now());
        [, $sinhvien] = $this->createStudentWithEmail();

        $hopdong = Hopdong::create([
            'sinhvien_id' => $sinhvien->id,
            'phong_id' => $this->phong->id,
            'giuong_id' => $this->giuong->id,
            'ngay_bat_dau' => now()->subMonths(6),
            'ngay_ket_thuc' => now()->addMonths(1),
            'trang_thai' => ContractStatus::Active,
            'gia_thuc_te' => (int) ($this->phong->loaiphong?->gia_thang ?? 0),
        ]);

        Hoadon::create([
            'hopdong_id' => $hopdong->id,
            'phong_id' => $this->phong->id,
            'ma_hoa_don' => 'HD-TEST-OVERDUE-2',
            'loai_hoadon' => Hoadon::LOAI_MONTHLY,
            'tien_phong' => 1500000,
            'tien_dien' => 0,
            'tien_nuoc' => 0,
            'phi_dich_vu' => 0,
            'tong_tien' => 1500000,
            'trang_thai' => InvoiceStatus::Unpaid,
            'ngay_het_han' => now()->subDay(),
            'ngay_thanh_toan' => null,
        ]);

        $this->artisan('hoadon:kiem-tra-qua-han')->assertSuccessful();

        Mail::assertQueued(NhacNoHoaDon::class, function ($mail) {
            return $mail->hasTo('student@test.com');
        });
    }
}
