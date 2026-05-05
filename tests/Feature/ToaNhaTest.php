<?php

namespace Tests\Feature;

use App\Models\Phong;
use App\Models\ToaNha;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToaNhaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 1. test_admin_tao_toa_nha_thanh_cong
     */
    public function test_admin_tao_toa_nha_thanh_cong(): void
    {
        // Setup: đăng nhập admin
        $admin = User::factory()->superAdmin()->create();

        $data = [
            'ten_toa_nha' => 'Tòa A1',
            'ma_toa_nha' => 'A1',
            'mo_ta' => 'Tòa nhà mới xây',
        ];

        // Action: POST /admin/toa-nha/them
        $response = $this->actingAs($admin)
            ->post(route('admin.toanha.luu'), $data);

        // Assert: DB has toa_nha với ten đó
        $this->assertDatabaseHas('toa_nha', [
            'ten_toa_nha' => 'Tòa A1',
            'ma_toa_nha' => 'A1',
        ]);

        // Assert: redirect về index với success message
        $response->assertRedirect(route('admin.toanha.index'));
        $response->assertSessionHas('toast_noidung', 'Khởi tạo tòa nhà thành công.');
    }

    /**
     * 2. test_ten_toa_nha_phai_unique
     */
    public function test_ten_toa_nha_phai_unique(): void
    {
        // Setup: đã có ToaNha với ten = "Tòa A"
        ToaNha::factory()->create(['ten_toa_nha' => 'Tòa A', 'ma_toa_nha' => 'A']);
        $admin = User::factory()->superAdmin()->create();

        $data = [
            'ten_toa_nha' => 'Tòa A',
            'ma_toa_nha' => 'A2',
            'mo_ta' => 'Tòa nhà trùng tên',
        ];

        // Action: POST /admin/toa-nha/them
        $response = $this->actingAs($admin)
            ->from(route('admin.toanha.tao'))
            ->post(route('admin.toanha.luu'), $data);

        // Assert: response redirect back (validation fail), validation error trên field ten_toa_nha
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['ten_toa_nha']);
    }

    /**
     * 3. test_cap_nhat_toa_nha
     */
    public function test_cap_nhat_toa_nha(): void
    {
        // Setup: tạo ToaNha, đăng nhập admin
        $toaNha = ToaNha::factory()->create(['ten_toa_nha' => 'Tòa C cũ']);
        $admin = User::factory()->superAdmin()->create();

        $data = [
            'ten_toa_nha' => 'Tòa C mới',
            'ma_toa_nha' => $toaNha->ma_toa_nha,
            'mo_ta' => 'Đã cập nhật',
        ];

        // Action: PUT /admin/toa-nha/{id}
        $response = $this->actingAs($admin)
            ->put(route('admin.toanha.capnhat', $toaNha->id), $data);

        // Assert: DB record đã cập nhật ten mới
        $this->assertDatabaseHas('toa_nha', [
            'id' => $toaNha->id,
            'ten_toa_nha' => 'Tòa C mới',
        ]);
        $response->assertRedirect(route('admin.toanha.index'));
    }

    /**
     * 4. test_khong_the_xoa_toa_nha_con_phong
     */
    public function test_khong_the_xoa_toa_nha_con_phong(): void
    {
        // Setup: tạo ToaNha + tạo Phong thuộc tòa đó
        $toaNha = ToaNha::factory()->create();
        
        // Tạo phòng và giường có sinh viên đang ở (Occupied)
        $phong = Phong::factory()->create(['toa_nha_id' => $toaNha->id]);
        \App\Models\Giuong::factory()->create([
            'phong_id' => $phong->id,
            'trang_thai' => \App\Enums\BedStatus::Occupied
        ]);
        
        $admin = User::factory()->superAdmin()->create();

        // Action: DELETE /admin/toa-nha/{id}
        $response = $this->actingAs($admin)
            ->delete(route('admin.toanha.xoa', $toaNha->id));

        // Assert: response redirect back with error message
        $response->assertSessionHas('toast_loai', 'loi');
        
        // Assert: DB vẫn còn ToaNha đó
        $this->assertDatabaseHas('toa_nha', ['id' => $toaNha->id]);
    }

    /**
     * 5. test_co_the_xoa_toa_nha_khong_con_phong
     */
    public function test_co_the_xoa_toa_nha_khong_con_phong(): void
    {
        // Setup: tạo ToaNha không có phòng nào
        $toaNha = ToaNha::factory()->create();
        $admin = User::factory()->superAdmin()->create();

        // Action: DELETE /admin/toa-nha/{id}
        $response = $this->actingAs($admin)
            ->delete(route('admin.toanha.xoa', $toaNha->id));

        // Assert: DB đã soft-deleted record đó
        // Lưu ý: ToaNha model hiện tại không dùng SoftDeletes (xem Models\ToaNha.php)
        // Nếu không dùng SoftDeletes thì assertNull
        $this->assertNull(ToaNha::find($toaNha->id));
        $response->assertRedirect(route('admin.toanha.index'));
        $response->assertSessionHas('toast_loai', 'thanhcong');
    }
}
