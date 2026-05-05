<?php

namespace Tests\Feature;

use App\Enums\RegistrationStatus;
use App\Mail\PaymentRequestMail;
use App\Models\Dangky;
use App\Models\Giuong;
use App\Models\Hoadon;
use App\Models\LoaiPhong;
use App\Models\Phong;
use App\Models\ThanhToan;
use App\Models\ToaNha;
use App\Services\Admin\DangkyService;
use App\Contracts\Admin\HoanTienServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Mockery;
use Tests\TestCase;

class AdminApproveGuestDangkyStatusTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_duyet_ho_so_chuyen_trang_thai_sang_cho_thanh_toan(): void
    {
        Mail::fake();

        $phong = Phong::factory()->create();

        $dangky = Dangky::query()->create([
            'ho_ten' => 'Guest',
            'email' => 'guest@example.com',
            'toa_nha_id' => $phong->toa_nha_id,
            'loai_phong_id' => $phong->loai_phong_id,
            'phong_id' => $phong->id,
            'trang_thai' => RegistrationStatus::Pending->value,
            'lookup_token' => str_repeat('a', 32),
        ]);

        $service = new DangkyService(Mockery::mock(HoanTienServiceInterface::class));
        $result = $service->duyetHoSo($dangky->id);

        $this->assertSame('thanhcong', $result['toast_loai']);

        $dangky->refresh();
        $this->assertSame(RegistrationStatus::ApprovedPendingPayment->value, $dangky->trang_thai->value);

        Mail::assertQueued(PaymentRequestMail::class, function (PaymentRequestMail $mail) use ($dangky) {
            return $mail->dangky->is($dangky) && $mail->soTien === 1000000;
        });
    }

    public function test_xac_nhan_thanh_toan_guest_tao_hoa_don_coc_da_thanh_toan_va_tao_hoa_don_tien_phong_thang_dau(): void
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

        $dangky = Dangky::query()->create([
            'ho_ten' => 'Guest',
            'email' => 'guest@example.com',
            'toa_nha_id' => $toaNha->id,
            'loai_phong_id' => $loaiPhong->id,
            'phong_id' => $phong->id,
            'trang_thai' => RegistrationStatus::ApprovedPendingPayment->value,
            'lookup_token' => str_repeat('b', 32),
        ]);

        $service = new DangkyService(Mockery::mock(HoanTienServiceInterface::class));
        $result = $service->xacNhanThanhToan($dangky->id);

        $this->assertSame('thanhcong', $result['toast_loai']);

        $this->assertDatabaseHas('dangky', [
            'id' => $dangky->id,
            'trang_thai' => RegistrationStatus::Completed->value,
            'phong_id' => $phong->id,
        ]);

        $hoadonCoc = Hoadon::query()
            ->where('loai_hoadon', Hoadon::LOAI_DEPOSIT)
            ->first();

        $this->assertNotNull($hoadonCoc);
        $this->assertSame(1000000, (int) $hoadonCoc->tong_tien);
        $this->assertSame(\App\Enums\InvoiceStatus::Paid->value, $hoadonCoc->trang_thai->value);

        $this->assertDatabaseHas('thanh_toan', [
            'hoadon_id' => $hoadonCoc->id,
            'so_tien' => 1000000,
        ]);

        $this->assertSame(1, Hoadon::query()->where('loai_hoadon', 'monthly')->count());
        $this->assertSame(\App\Enums\BedStatus::Occupied->value, $giuong->refresh()->trang_thai->value);
    }
}
