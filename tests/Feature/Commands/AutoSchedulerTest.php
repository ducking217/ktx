<?php

namespace Tests\Feature\Commands;

use App\Enums\ContractStatus;
use App\Enums\InvoiceStatus;
use App\Mail\CanhBaoHetHanHopDong;
use App\Mail\NhacNoHoaDon;
use App\Models\Hoadon;
use App\Models\Hopdong;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\ToaNha;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AutoSchedulerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $toaNha = ToaNha::create([
            'ten_toa_nha' => 'Tòa A1',
            'ma_toa_nha' => 'A1',
        ]);

        $this->phong = Phong::create([
            'tenphong' => 'P101',
            'tang' => 1,
            'giaphong' => 1500000,
            'succhuamax' => 4,
            'dango' => 1,
            'toa_nha_id' => $toaNha->id,
        ]);
    }

    private function createStudentWithEmail()
    {
        $user = User::factory()->create([
            'email' => 'student@test.com',
        ]);

        $sinhvien = Sinhvien::create([
            'user_id' => $user->id,
            'masinhvien' => 'SV' . $user->id,
            'phong_id' => $this->phong->id,
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
            'ngay_bat_dau' => now()->subMonths(6),
            'ngay_ket_thuc' => now()->subDay(), // Hết hạn hôm qua
            'trang_thai' => ContractStatus::Active->value,
            'giaphong_luc_ky' => $this->phong->giaphong,
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
            'ngay_bat_dau' => now()->subMonths(5),
            'ngay_ket_thuc' => now()->addDays(29), // Rơi vào khoảng Between(28, 30)
            'trang_thai' => ContractStatus::Active->value,
            'giaphong_luc_ky' => $this->phong->giaphong,
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
        Carbon::setTestNow(now());
        [, $sinhvien] = $this->createStudentWithEmail();

        $hoadon = Hoadon::create([
            'sinhvien_id' => $sinhvien->id,
            'phong_id' => $this->phong->id,
            'thang' => now()->subMonth()->month,
            'nam' => now()->year,
            'tongtien' => 1500000,
            'trangthaithanhtoan' => InvoiceStatus::Pending->value,
            'ngayxuat' => now()->subDays(31)->format('Y-m-d'), // Quá hạn 30 ngày
            'loai_hoadon' => Hoadon::LOAI_MONTHLY,
        ]);

        $this->artisan('hoadon:kiem-tra-qua-han')->assertSuccessful();

        $hoadon->refresh();
        $this->assertEquals(InvoiceStatus::Overdue, $hoadon->trangthaithanhtoan);
    }

    /**
     * 4. test_command_gui_email_nhac_no
     */
    public function test_command_gui_email_nhac_no()
    {
        Mail::fake();
        Carbon::setTestNow(now());
        [, $sinhvien] = $this->createStudentWithEmail();

        $hoadon = Hoadon::create([
            'sinhvien_id' => $sinhvien->id,
            'phong_id' => $this->phong->id,
            'thang' => now()->subMonth()->month,
            'nam' => now()->year,
            'tongtien' => 1500000,
            'trangthaithanhtoan' => InvoiceStatus::Pending->value,
            'ngayxuat' => now()->subDays(31)->format('Y-m-d'),
            'loai_hoadon' => Hoadon::LOAI_MONTHLY,
        ]);

        $this->artisan('hoadon:kiem-tra-qua-han')->assertSuccessful();

        Mail::assertQueued(NhacNoHoaDon::class, function ($mail) {
            return $mail->hasTo('student@test.com');
        });
    }
}
