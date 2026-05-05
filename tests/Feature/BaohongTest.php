<?php

namespace Tests\Feature;

use App\Enums\BaohongStatus;
use App\Enums\BedStatus;
use App\Enums\ContractStatus;
use App\Models\Baohong;
use App\Models\Giuong;
use App\Models\Hopdong;
use App\Models\LoaiPhong;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\ToaNha;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Feature tests for the student damage-report (báo hỏng) flow.
 *
 * Covers:
 *  - GET list page (view loads correctly)
 *  - Validation rules (empty, too short, too long, bad file type)
 *  - Auth guard (unauthenticated / wrong role)
 *  - Business guard (no sinhvien profile / no active hopdong)
 *  - Happy path (successful submission creates DB record + correct session)
 *  - Idempotency: multiple submissions create multiple records (no silent dedup)
 */
class BaohongTest extends TestCase
{
    use RefreshDatabase;

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Returns a real 1×1 white JPEG UploadedFile without requiring the GD extension.
     * The raw JPEG bytes are embedded as base64.
     */
    private function fakeTinyJpeg(string $name = 'test.jpg', int $sizeKb = 1): UploadedFile
    {
        // Standard 1×1 white pixel JPEG (no GD needed)
        $jpegBytes = base64_decode(
            '/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8U'
            . 'HRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/wAARCAABAAEDASIA'
            . 'AhEBAxEB/8QAFAABAAAAAAAAAAAAAAAAAAAACf/EABQQAQAAAAAAAAAAAAAAAAAAAAD/xAAU'
            . 'AQEAAAAAAAAAAAAAAAAAAAAA/8QAFBEBAAAAAAAAAAAAAAAAAAAAAP/aAAwDAQACEQMRAD8A'
            . 'JQAB/9k='
        );

        $tmp = tempnam(sys_get_temp_dir(), 'baohong_test_') . '.jpg';
        file_put_contents($tmp, $jpegBytes);

        // If a custom size was requested, pad the file
        if ($sizeKb > 1) {
            file_put_contents($tmp, str_repeat('\0', ($sizeKb - 1) * 1024), FILE_APPEND);
        }

        return new UploadedFile($tmp, $name, 'image/jpeg', null, true);
    }

    private function taoSinhVienCoPhong(): array
    {
        $toaNha    = ToaNha::factory()->create();
        $loaiPhong = LoaiPhong::factory()->create(['gia_thang' => 1_500_000, 'suc_chua' => 4]);
        $phong     = Phong::factory()->create([
            'toa_nha_id'    => $toaNha->id,
            'loai_phong_id' => $loaiPhong->id,
            'ten_phong'     => 'A101',
        ]);
        $giuong = Giuong::factory()->create([
            'phong_id'   => $phong->id,
            'trang_thai' => BedStatus::Occupied,
        ]);
        $user = User::factory()->sinhvien()->create();
        $sinhvien = Sinhvien::factory()->create(['user_id' => $user->id]);

        Hopdong::factory()->create([
            'sinhvien_id'  => $sinhvien->id,
            'phong_id'     => $phong->id,
            'giuong_id'    => $giuong->id,
            'ngay_bat_dau' => now()->subMonths(1)->format('Y-m-d'),
            'ngay_ket_thuc'=> now()->addMonths(5)->format('Y-m-d'),
            'gia_thuc_te'  => 1_500_000,
            'trang_thai'   => ContractStatus::Active,
        ]);

        return compact('user', 'sinhvien', 'phong', 'giuong');
    }

    private function taoSinhVienKhongCoPhong(): array
    {
        $user     = User::factory()->sinhvien()->create();
        $sinhvien = Sinhvien::factory()->create(['user_id' => $user->id]);
        return compact('user', 'sinhvien');
    }

    private function routeStore(): string
    {
        return route('student.thembaohong');
    }

    private function routeList(): string
    {
        return route('student.danhsachbaohong');
    }

    // ─── Auth Guard Tests ──────────────────────────────────────────────────────

    public function test_guest_khong_the_gui_baohong(): void
    {
        $response = $this->post($this->routeStore(), ['mota' => 'Bóng đèn tầng 2 bị hỏng rồi.']);
        $response->assertRedirect(route('login'));
    }

    public function test_admin_khong_co_quyen_dung_route_student(): void
    {
        $admin = User::factory()->admin()->create();
        $response = $this->actingAs($admin)->post($this->routeStore(), ['mota' => 'Bóng đèn tầng 2 bị hỏng rồi.']);
        // Role middleware redirects admin to dashboard
        $response->assertRedirect(route('dashboard'));
    }

    // ─── List Page ─────────────────────────────────────────────────────────────

    public function test_trang_danh_sach_hien_thi_dung_cho_sinhvien_co_phong(): void
    {
        $data = $this->taoSinhVienCoPhong();
        $response = $this->actingAs($data['user'])->get($this->routeList());
        $response->assertOk();
        $response->assertViewIs('student.baohong.danhsach');
        $response->assertViewHas('sinhvien');
        $response->assertViewHas('danhsachbaohong');
        $response->assertSee('modal-thembaohong');
    }

    public function test_trang_danh_sach_hien_thi_nut_disabled_khi_chua_co_phong(): void
    {
        $data = $this->taoSinhVienKhongCoPhong();
        $response = $this->actingAs($data['user'])->get($this->routeList());
        $response->assertOk();
        $response->assertSee('Chưa có phòng để báo hỏng');
    }

    // ─── Validation Tests ──────────────────────────────────────────────────────

    public function test_validation_that_bai_khi_mota_trong(): void
    {
        $data = $this->taoSinhVienCoPhong();
        $response = $this->actingAs($data['user'])->post($this->routeStore(), ['mota' => '']);
        $response->assertSessionHasErrors('mota');
        $this->assertDatabaseCount('baohong', 0);
    }

    public function test_validation_that_bai_khi_mota_qua_ngan(): void
    {
        $data = $this->taoSinhVienCoPhong();
        $response = $this->actingAs($data['user'])->post($this->routeStore(), ['mota' => 'Ngắn']);
        $response->assertSessionHasErrors('mota');
        $this->assertDatabaseCount('baohong', 0);
    }

    public function test_validation_that_bai_khi_mota_qua_dai(): void
    {
        $data = $this->taoSinhVienCoPhong();
        $response = $this->actingAs($data['user'])->post($this->routeStore(), [
            'mota' => str_repeat('a', 2001),
        ]);
        $response->assertSessionHasErrors('mota');
        $this->assertDatabaseCount('baohong', 0);
    }

    public function test_validation_that_bai_khi_anh_sai_dinh_dang(): void
    {
        $data = $this->taoSinhVienCoPhong();
        $fakeFile = UploadedFile::fake()->create('virus.exe', 100, 'application/octet-stream');
        $response = $this->actingAs($data['user'])->post($this->routeStore(), [
            'mota'       => 'Bóng đèn hỏng cần sửa gấp lắm rồi.',
            'anhminhhoa' => $fakeFile,
        ]);
        $response->assertSessionHasErrors('anhminhhoa');
        $this->assertDatabaseCount('baohong', 0);
    }

    public function test_validation_that_bai_khi_anh_qua_lon(): void
    {
        $data = $this->taoSinhVienCoPhong();
        // Create a real JPEG slightly above the 4MB limit (4097 KB) — no GD needed
        $fakeFile = $this->fakeTinyJpeg('anhbaohong.jpg', 4097);
        $response = $this->actingAs($data['user'])->post($this->routeStore(), [
            'mota'       => 'Bóng đèn hỏng cần sửa gấp lắm rồi.',
            'anhminhhoa' => $fakeFile,
        ]);
        $response->assertSessionHasErrors('anhminhhoa');
        $this->assertDatabaseCount('baohong', 0);
    }

    // ─── Business Logic Guard Tests ────────────────────────────────────────────

    public function test_sinhvien_khong_co_profile_bi_tu_choi(): void
    {
        // Logged in as sinhvien role but no Sinhvien record in DB
        $user = User::factory()->sinhvien()->create();
        $response = $this->actingAs($user)->post($this->routeStore(), [
            'mota' => 'Bóng đèn hỏng cần sửa gấp lắm rồi.',
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('toast_loai', 'loi');
        $this->assertDatabaseCount('baohong', 0);
    }

    public function test_sinhvien_khong_co_hopdong_bi_tu_choi(): void
    {
        $data = $this->taoSinhVienKhongCoPhong();
        $response = $this->actingAs($data['user'])->post($this->routeStore(), [
            'mota' => 'Bóng đèn hỏng cần sửa gấp lắm rồi.',
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('toast_loai', 'loi');
        $this->assertDatabaseCount('baohong', 0);
    }

    public function test_sinhvien_co_hopdong_terminated_bi_tu_choi(): void
    {
        $data = $this->taoSinhVienCoPhong();
        // Terminate the contract
        Hopdong::where('sinhvien_id', $data['sinhvien']->id)->update(['trang_thai' => ContractStatus::Terminated]);

        $response = $this->actingAs($data['user'])->post($this->routeStore(), [
            'mota' => 'Bóng đèn hỏng cần sửa gấp lắm rồi.',
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('toast_loai', 'loi');
        $this->assertDatabaseCount('baohong', 0);
    }

    // ─── Happy Path ────────────────────────────────────────────────────────────

    public function test_gui_baohong_thanh_cong_tao_ban_ghi_va_flash_toast(): void
    {
        $data = $this->taoSinhVienCoPhong();
        $response = $this->actingAs($data['user'])->post($this->routeStore(), [
            'mota' => 'Bóng đèn tầng 2 hỏng, cần thay gấp.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('toast_loai', 'thanhcong');

        $this->assertDatabaseHas('baohong', [
            'sinhvien_id' => $data['sinhvien']->id,
            'phong_id'    => $data['phong']->id,
            'mo_ta'       => 'Bóng đèn tầng 2 hỏng, cần thay gấp.',
            'trang_thai'  => BaohongStatus::Pending->value,
            'muc_do'      => 'low',
        ]);
    }

    public function test_gui_baohong_voi_anh_dinh_kem(): void
    {
        $data = $this->taoSinhVienCoPhong();
        // Vietnamese filename intentionally used to verify sanitization — no GD needed
        $fakeImage = $this->fakeTinyJpeg('ảnh hỏng.jpg', 200);

        $response = $this->actingAs($data['user'])->post($this->routeStore(), [
            'mota'       => 'Vòi nước bị rỉ nước liên tục, cần sửa.',
            'anhminhhoa' => $fakeImage,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('toast_loai', 'thanhcong');

        $baohong = Baohong::where('sinhvien_id', $data['sinhvien']->id)->first();
        $this->assertNotNull($baohong);
        $this->assertNotNull($baohong->hinh_anh_path);
        // Filename must NOT contain the original Vietnamese name (sanitized)
        $this->assertStringNotContainsString('ảnh', $baohong->hinh_anh_path);
        $this->assertStringStartsWith('anhbaohong/', $baohong->hinh_anh_path);
    }

    public function test_nhieu_lan_gui_tao_nhieu_ban_ghi_rieng(): void
    {
        $data = $this->taoSinhVienCoPhong();

        $this->actingAs($data['user'])->post($this->routeStore(), [
            'mota' => 'Lần 1: Bóng đèn phòng tắm hỏng hoàn toàn.',
        ]);
        $this->actingAs($data['user'])->post($this->routeStore(), [
            'mota' => 'Lần 2: Cửa sổ phòng bị kẹt không mở được.',
        ]);

        $this->assertDatabaseCount('baohong', 2);
    }

    public function test_gui_baohong_thanh_cong_ket_qua_json(): void
    {
        $data = $this->taoSinhVienCoPhong();
        $response = $this->actingAs($data['user'])
            ->withHeaders(['Accept' => 'application/json'])
            ->post($this->routeStore(), [
                'mota' => 'Điện phòng bị chập, cần kiểm tra ngay.',
            ]);

        $response->assertStatus(201);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(['success', 'message', 'data' => ['id']]);
    }

    public function test_gui_baohong_that_bai_tra_ve_json_400(): void
    {
        // Logged in but no sinhvien profile → service returns loi
        $user = User::factory()->sinhvien()->create();
        $response = $this->actingAs($user)
            ->withHeaders(['Accept' => 'application/json'])
            ->post($this->routeStore(), [
                'mota' => 'Bóng đèn hỏng cần kiểm tra ngay.',
            ]);

        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
    }

    // ─── Audit Log ─────────────────────────────────────────────────────────────

    public function test_gui_baohong_tao_nhat_ky_audit(): void
    {
        $data = $this->taoSinhVienCoPhong();
        $this->actingAs($data['user'])->post($this->routeStore(), [
            'mota' => 'Hệ thống nước nóng bị hỏng, không có nước nóng.',
        ]);

        $this->assertDatabaseHas('nhat_ky', [
            'hanh_dong' => 'create',
            'ten_model' => 'Baohong',
        ]);
    }
}
