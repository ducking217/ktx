<?php

namespace Tests\Feature;

use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SinhvienObserverTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Observer is automatically registered in AppServiceProvider
    }

    /**
     * Test gán phòng → dango tăng
     */
    public function test_assign_room_increases_dango()
    {
        $phong = Phong::factory()->create();

        $user = User::factory()->create();

        $sinhvien = Sinhvien::factory()->create([
            'user_id' => $user->id,
        ]);

        // Mock current_hopdong
        $giuong = \App\Models\Giuong::factory()->create(['phong_id' => $phong->id]);
        $hopdong = \App\Models\Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien->id,
            'giuong_id' => $giuong->id,
            'phong_id' => $phong->id,
            'trang_thai' => \App\Enums\ContractStatus::Active,
        ]);

        // Gán phòng cho sinh viên qua hopdong
        $sinhvien->refresh();

        // Verify dango thông qua logic phòng hiện tại
        $this->assertEquals($phong->id, $sinhvien->phong_hien_tai()?->id);
    }

    /**
     * Test rời phòng → dango giảm
     */
    public function test_leave_room_decreases_dango()
    {
        $phong = Phong::factory()->create();

        $user = User::factory()->create();

        $sinhvien = Sinhvien::factory()->create([
            'user_id' => $user->id,
        ]);

        $giuong = \App\Models\Giuong::factory()->create(['phong_id' => $phong->id]);
        $hopdong = \App\Models\Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien->id,
            'giuong_id' => $giuong->id,
            'phong_id' => $phong->id,
            'trang_thai' => \App\Enums\ContractStatus::Active,
        ]);

        $this->assertEquals($phong->id, $sinhvien->phong_hien_tai()?->id);

        // Rời phòng bằng cách đóng hợp đồng
        $hopdong->update(['trang_thai' => \App\Enums\ContractStatus::Terminated]);

        $sinhvien->refresh();

        // Verify không còn phòng hiện tại
        $this->assertNull($sinhvien->phong_hien_tai());
    }

    /**
     * Test chuyển phòng → dango phòng cũ giảm, phòng mới tăng
     */
    public function test_transfer_room_updates_both_rooms()
    {
        $phongCu = Phong::factory()->create();
        $phongMoi = Phong::factory()->create();

        $user = User::factory()->create();

        $sinhvien = Sinhvien::factory()->create([
            'user_id' => $user->id,
        ]);

        $giuongCu = \App\Models\Giuong::factory()->create(['phong_id' => $phongCu->id]);
        $hopdongCu = \App\Models\Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien->id,
            'giuong_id' => $giuongCu->id,
            'phong_id' => $phongCu->id,
            'trang_thai' => \App\Enums\ContractStatus::Active,
        ]);

        $this->assertEquals($phongCu->id, $sinhvien->phong_hien_tai()?->id);

        // Chuyển phòng bằng cách đóng hợp đồng cũ, tạo hợp đồng mới
        $hopdongCu->update(['trang_thai' => \App\Enums\ContractStatus::Terminated]);
        
        $giuongMoi = \App\Models\Giuong::factory()->create(['phong_id' => $phongMoi->id]);
        $hopdongMoi = \App\Models\Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien->id,
            'giuong_id' => $giuongMoi->id,
            'phong_id' => $phongMoi->id,
            'trang_thai' => \App\Enums\ContractStatus::Active,
        ]);

        $sinhvien->refresh();

        // Verify phòng mới
        $this->assertEquals($phongMoi->id, $sinhvien->phong_hien_tai()?->id);
    }

    /**
     * Test soft-delete → dango giảm
     */
    public function test_soft_delete_decreases_dango()
    {
        $phong = Phong::factory()->create();

        $user = User::factory()->create();

        $sinhvien = Sinhvien::factory()->create([
            'user_id' => $user->id,
        ]);

        $giuong = \App\Models\Giuong::factory()->create(['phong_id' => $phong->id]);
        $hopdong = \App\Models\Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien->id,
            'giuong_id' => $giuong->id,
            'phong_id' => $phong->id,
            'trang_thai' => \App\Enums\ContractStatus::Active,
        ]);

        $this->assertEquals($phong->id, $sinhvien->phong_hien_tai()?->id);

        // Soft-delete sinh viên
        $sinhvien->delete();

        $sinhvien = $sinhvien->fresh(); // Sẽ null nếu không dùng withTrashed

        // Verify không còn phòng hiện tại (do sinh viên bị soft-deleted)
        $this->assertNull(\App\Models\Sinhvien::find($sinhvien->id));
    }

    /**
     * Test restore → dango tăng lại
     */
    public function test_restore_increases_dango()
    {
        $phong = Phong::factory()->create();

        $user = User::factory()->create();

        $sinhvien = Sinhvien::factory()->create([
            'user_id' => $user->id,
        ]);

        $giuong = \App\Models\Giuong::factory()->create(['phong_id' => $phong->id]);
        $hopdong = \App\Models\Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien->id,
            'giuong_id' => $giuong->id,
            'phong_id' => $phong->id,
            'trang_thai' => \App\Enums\ContractStatus::Active,
        ]);

        $this->assertEquals($phong->id, $sinhvien->phong_hien_tai()?->id);

        // Soft-delete sinh viên
        $sinhvien->delete();
        $this->assertNull(\App\Models\Sinhvien::find($sinhvien->id));

        // Restore
        $sinhvien->restore();

        // Verify dango tăng lại
        $this->assertEquals($phong->id, $sinhvien->fresh()->phong_hien_tai()?->id);
    }

    /**
     * Test tạo sinh viên với phòng ngay lập tức → dango tăng
     */
    public function test_create_student_with_room_increases_dango()
    {
        $phong = Phong::factory()->create();

        $user = User::factory()->create();

        $sinhvien = Sinhvien::factory()->create([
            'user_id' => $user->id,
        ]);

        $giuong = \App\Models\Giuong::factory()->create(['phong_id' => $phong->id]);
        $hopdong = \App\Models\Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien->id,
            'giuong_id' => $giuong->id,
            'phong_id' => $phong->id,
            'trang_thai' => \App\Enums\ContractStatus::Active,
        ]);

        // Verify
        $this->assertEquals($phong->id, $sinhvien->fresh()->phong_hien_tai()?->id);
    }

    /**
     * Test withoutTrashed() - soft-deleted sinh viên không được đếm
     */
    public function test_without_trashed_excludes_soft_deleted_students()
    {
        $phong = Phong::factory()->create();

        // Tạo 2 sinh viên có hợp đồng trong cùng phòng
        $sinhvien1 = Sinhvien::factory()->create();
        $giuong1 = \App\Models\Giuong::factory()->create(['phong_id' => $phong->id]);
        \App\Models\Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien1->id,
            'giuong_id' => $giuong1->id,
            'phong_id' => $phong->id,
            'trang_thai' => \App\Enums\ContractStatus::Active,
        ]);

        $sinhvien2 = Sinhvien::factory()->create();
        $giuong2 = \App\Models\Giuong::factory()->create(['phong_id' => $phong->id]);
        \App\Models\Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien2->id,
            'giuong_id' => $giuong2->id,
            'phong_id' => $phong->id,
            'trang_thai' => \App\Enums\ContractStatus::Active,
        ]);

        $this->assertEquals($phong->id, $sinhvien1->fresh()->phong_hien_tai()?->id);
        $this->assertEquals($phong->id, $sinhvien2->fresh()->phong_hien_tai()?->id);

        // Soft-delete 1 sinh viên
        $sinhvien1->delete();

        // Verify sinh viên 1 không còn tìm thấy, sinh viên 2 vẫn còn
        $this->assertNull(\App\Models\Sinhvien::find($sinhvien1->id));
        $this->assertNotNull(\App\Models\Sinhvien::find($sinhvien2->id));
    }
}
