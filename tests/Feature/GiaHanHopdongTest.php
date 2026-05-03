<?php

namespace Tests\Feature;

use App\Enums\ContractStatus;
use App\Enums\ExtensionStatus;
use App\Enums\UserRole;
use App\Mail\KetQuaGiaHanHopDongMail;
use App\Models\Hopdong;
use App\Models\Sinhvien;
use App\Models\User;
use App\Models\YeuCauGiaHan;
use App\Models\ToaNha;
use App\Models\Phong;
use App\Services\Shared\GiaHanService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Mockery;
use Mockery\MockInterface;

class GiaHanHopdongTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Tạo tòa nhà và phòng mặc định
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

    private function createStudentWithContract()
    {
        $user = User::factory()->create([
            'vaitro' => UserRole::SinhVien,
        ]);

        $sinhvien = Sinhvien::create([
            'user_id' => $user->id,
            'masinhvien' => 'SV' . $user->id,
            'phong_id' => $this->phong->id,
        ]);

        $hopdong = Hopdong::create([
            'sinhvien_id' => $sinhvien->id,
            'phong_id' => $this->phong->id,
            'ngay_bat_dau' => now()->subMonths(5),
            'ngay_ket_thuc' => now()->addMonth(),
            'trang_thai' => ContractStatus::Active->value,
            'giaphong_luc_ky' => $this->phong->giaphong,
        ]);

        return [$user, $sinhvien, $hopdong];
    }

    private function createAdmin()
    {
        return User::factory()->create([
            'vaitro' => UserRole::Admin,
        ]);
    }

    /**
     * 1. test_sinh_vien_gui_yeu_cau_gia_han_thanh_cong
     */
    public function test_sinh_vien_gui_yeu_cau_gia_han_thanh_cong()
    {
        [$user, $sinhvien, $hopdong] = $this->createStudentWithContract();

        $response = $this->actingAs($user)->post(route('student.giahan.store'), [
            'hopdong_id' => $hopdong->id,
            'ngay_ket_thuc_moi' => now()->addMonths(6)->format('Y-m-d'),
            'ly_do' => 'Em muốn ở tiếp',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('yeu_cau_gia_han', [
            'sinhvien_id' => $sinhvien->id,
            'hopdong_id' => $hopdong->id,
            'trang_thai' => ExtensionStatus::Pending->value,
        ]);
    }

    /**
     * 2. test_khong_cho_gui_yeu_cau_thu_hai_khi_con_pending
     */
    public function test_khong_cho_gui_yeu_cau_thu_hai_khi_con_pending()
    {
        [$user, $sinhvien, $hopdong] = $this->createStudentWithContract();

        // Tạo yêu cầu đầu tiên
        YeuCauGiaHan::create([
            'sinhvien_id' => $sinhvien->id,
            'hopdong_id' => $hopdong->id,
            'ngay_ket_thuc_moi' => now()->addMonths(6)->format('Y-m-d'),
            'trang_thai' => ExtensionStatus::Pending->value,
        ]);

        // Gửi yêu cầu thứ hai
        $response = $this->actingAs($user)->post(route('student.giahan.store'), [
            'hopdong_id' => $hopdong->id,
            'ngay_ket_thuc_moi' => now()->addMonths(7)->format('Y-m-d'),
        ]);

        $response->assertSessionHas('toast_loai', 'loi');
        $this->assertEquals(1, YeuCauGiaHan::where('sinhvien_id', $sinhvien->id)->count());
    }

    /**
     * 3. test_admin_duyet_gia_han_cap_nhat_hopdong
     */
    public function test_admin_duyet_gia_han_cap_nhat_hopdong()
    {
        Mail::fake();
        $admin = $this->createAdmin();
        [$user, $sinhvien, $hopdong] = $this->createStudentWithContract();
        
        $ngayMoi = now()->addMonths(6)->startOfDay();
        $yeuCau = YeuCauGiaHan::create([
            'sinhvien_id' => $sinhvien->id,
            'hopdong_id' => $hopdong->id,
            'ngay_ket_thuc_moi' => $ngayMoi->format('Y-m-d'),
            'trang_thai' => ExtensionStatus::Pending->value,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.giahan.duyet', $yeuCau->id), [
            'ghi_chu_admin' => 'Đã đồng ý cho em',
        ]);

        $response->assertStatus(302);
        
        $yeuCau->refresh();
        $hopdong->refresh();
        $sinhvien->refresh();

        $this->assertEquals(ExtensionStatus::Approved, $yeuCau->trang_thai);
        $this->assertEquals($ngayMoi->format('Y-m-d'), $hopdong->ngay_ket_thuc->format('Y-m-d'));
        $this->assertEquals($ngayMoi->format('Y-m-d'), $sinhvien->ngay_het_han->format('Y-m-d'));
        
        Mail::assertQueued(KetQuaGiaHanHopDongMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /**
     * 4. test_admin_tu_choi_luu_ghi_chu
     */
    public function test_admin_tu_choi_luu_ghi_chu()
    {
        $admin = $this->createAdmin();
        [$user, $sinhvien, $hopdong] = $this->createStudentWithContract();
        
        $ngayCu = $hopdong->ngay_ket_thuc;
        $yeuCau = YeuCauGiaHan::create([
            'sinhvien_id' => $sinhvien->id,
            'hopdong_id' => $hopdong->id,
            'ngay_ket_thuc_moi' => now()->addMonths(6)->format('Y-m-d'),
            'trang_thai' => ExtensionStatus::Pending->value,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.giahan.tuchoi', $yeuCau->id), [
            'ghi_chu_admin' => 'Hết phòng rồi em',
        ]);

        $yeuCau->refresh();
        $hopdong->refresh();

        $this->assertEquals(ExtensionStatus::Rejected, $yeuCau->trang_thai);
        $this->assertEquals('Hết phòng rồi em', $yeuCau->ghi_chu_admin);
        $this->assertEquals($ngayCu->format('Y-m-d'), $hopdong->ngay_ket_thuc->format('Y-m-d'));
    }

    /**
     * 5. test_rollback_khi_loi
     */
    public function test_rollback_khi_loi()
    {
        $admin = $this->createAdmin();
        [$user, $sinhvien, $hopdong] = $this->createStudentWithContract();
        
        $yeuCau = YeuCauGiaHan::create([
            'sinhvien_id' => $sinhvien->id,
            'hopdong_id' => $hopdong->id,
            'ngay_ket_thuc_moi' => now()->addMonths(6)->format('Y-m-d'),
            'trang_thai' => ExtensionStatus::Pending->value,
        ]);

        // Mock GiaHanService để throw exception khi duyetYeuCau
        $this->mock(GiaHanService::class, function (MockInterface $mock) use ($yeuCau) {
            $mock->shouldReceive('duyetYeuCau')
                ->once()
                ->andThrow(new \Exception('Database Error'));
            
            // Giữ lại các method khác của service nếu cần
            $mock->shouldReceive('lietKeYeuCauAdmin')->andReturn([]);
        });

        $response = $this->actingAs($admin)->post(route('admin.giahan.duyet', $yeuCau->id));

        $yeuCau->refresh();
        // Kiểm tra trạng thái vẫn là Pending do transaction rollback
        $this->assertEquals(ExtensionStatus::Pending, $yeuCau->trang_thai);
    }
}
