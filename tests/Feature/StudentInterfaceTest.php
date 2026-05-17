<?php

namespace Tests\Feature;

use App\Models\Giuong;
use App\Models\Hopdong;
use App\Models\LoaiPhong;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\ToaNha;
use App\Models\User;
use App\Enums\BedStatus;
use App\Enums\ContractStatus;
use App\Enums\Gender;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudentInterfaceTest extends TestCase
{
    use RefreshDatabase;

    private ToaNha $toaNha;
    private LoaiPhong $loaiPhong;
    private Phong $phong;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup base data
        $this->toaNha = ToaNha::create([
            'ten_toa_nha' => 'Toòa A',
            'ma_toa_nha' => 'TOA_A',
            'gioi_tinh' => 'any',
            'dia_chi' => 'Khu A',
        ]);

        $this->loaiPhong = LoaiPhong::create([
            'ten_loai' => 'Standard',
            'suc_chua' => 4,
            'gia_thang' => 500000,
            'tien_nghi' => ['wifi'],
        ]);

        $this->phong = Phong::create([
            'toa_nha_id' => $this->toaNha->id,
            'loai_phong_id' => $this->loaiPhong->id,
            'ten_phong' => 'A101',
            'tang' => 1,
            'gioi_tinh_han_che' => Gender::Male,
            'trang_thai' => 'active',
        ]);

        // Create 4 beds, 2 available, 2 occupied
        for ($i = 1; $i <= 4; $i++) {
            Giuong::create([
                'phong_id' => $this->phong->id,
                'ma_giuong' => "A101-$i",
                'trang_thai' => $i <= 2 ? BedStatus::Available : BedStatus::Occupied,
            ]);
        }
    }

    public function test_student_can_view_vacant_rooms()
    {
        $user = User::factory()->create(['vaitro' => UserRole::Student, 'gender' => Gender::Male]);
        Sinhvien::create([
            'user_id' => $user->id,
            'ma_sinh_vien' => 'SV001',
            'lop' => 'CNTT1',
            'khoa' => 'CNTT',
            'ngay_nhap_hoc' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('student.phong.index'));

        $response->assertStatus(200);
        $response->assertSee('A101');
        $response->assertSee('Standard');
        $response->assertSee('500,000');
        $response->assertSee('2 giường trống');
    }

    public function test_student_can_create_maintenance_report()
    {
        $user = User::factory()->create(['vaitro' => UserRole::Student, 'gender' => Gender::Male]);
        $sinhvien = Sinhvien::create([
            'user_id' => $user->id,
            'ma_sinh_vien' => 'SV002',
            'lop' => 'CNTT1',
            'khoa' => 'CNTT',
            'ngay_nhap_hoc' => now(),
        ]);

        // Create active contract
        $giuong = Giuong::where('phong_id', $this->phong->id)->where('trang_thai', BedStatus::Occupied)->first();
        Hopdong::create([
            'sinhvien_id' => $sinhvien->id,
            'phong_id' => $this->phong->id,
            'giuong_id' => $giuong->id,
            'ngay_bat_dau' => now(),
            'ngay_ket_thuc' => now()->addYear(),
            'trang_thai' => ContractStatus::Active,
            'gia_thuc_te' => 500000,
            'tien_coc' => 500000,
        ]);

        Storage::fake('public');
        $file = UploadedFile::fake()->create('damage.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($user)->post(route('student.thembaohong'), [
            'mota' => 'Bóng đèn bị hỏng',
            'anhminhhoa' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('toast_loai', 'thanhcong');
        
        $this->assertDatabaseHas('baohong', [
            'sinhvien_id' => $sinhvien->id,
            'mo_ta' => 'Bóng đèn bị hỏng',
        ]);
    }

    public function test_student_cannot_report_damage_without_active_contract()
    {
        $user = User::factory()->create(['vaitro' => UserRole::Student]);
        Sinhvien::create([
            'user_id' => $user->id,
            'ma_sinh_vien' => 'SV003',
            'lop' => 'CNTT1',
            'khoa' => 'CNTT',
            'ngay_nhap_hoc' => now(),
        ]);

        $response = $this->actingAs($user)->post(route('student.thembaohong'), [
            'mota' => 'Lỗi linh tinh',
        ]);

        $response->assertSessionHas('toast_loai', 'loi');
        $response->assertSessionHas('toast_noidung', 'Bạn chưa được xếp phòng hoặc hợp đồng không còn hiệu lực.');
    }

    public function test_student_can_book_room_successfully()
    {
        $user = User::factory()->create(['vaitro' => UserRole::Student, 'gender' => Gender::Male]);
        Sinhvien::create([
            'user_id' => $user->id,
            'ma_sinh_vien' => 'SV_BOOK_001',
            'lop' => 'CNTT1',
            'khoa' => 'CNTT',
            'ngay_nhap_hoc' => now(),
        ]);

        $response = $this->actingAs($user)->post(route('student.dangkyphong'), [
            'phong_id' => $this->phong->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('toast_loai', 'thanhcong');
        
        $this->assertDatabaseHas('dangky', [
            'user_id' => $user->id,
            'phong_id' => $this->phong->id,
            'toa_nha_id' => $this->phong->toa_nha_id,
            'loai_phong_id' => $this->phong->loai_phong_id,
        ]);
    }
}
