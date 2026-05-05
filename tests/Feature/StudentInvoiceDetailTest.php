<?php

namespace Tests\Feature;

use App\Enums\ContractStatus;
use App\Enums\InvoiceStatus;
use App\Models\ChiSoDienNuoc;
use App\Models\Giuong;
use App\Models\Hoadon;
use App\Models\Hopdong;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class StudentInvoiceDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_view_invoice_detail_with_multiple_items(): void
    {
        $user = User::factory()->sinhvien()->create();
        $sinhvien = Sinhvien::factory()->create(['user_id' => $user->id]);
        $phong = Phong::factory()->create();
        $giuong = Giuong::factory()->create(['phong_id' => $phong->id]);
        $hopdong = Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien->id,
            'phong_id' => $phong->id,
            'giuong_id' => $giuong->id,
            'trang_thai' => ContractStatus::Active,
        ]);

        $hoadon = Hoadon::factory()->create([
            'hopdong_id' => $hopdong->id,
            'phong_id' => $phong->id,
            'trang_thai' => InvoiceStatus::Unpaid,
            'ghi_chu' => 'Ky 5/2026',
            'tien_phong' => 1500000,
            'tien_dien' => 200000,
            'tien_nuoc' => 100000,
            'phi_dich_vu' => 50000,
            'tong_tien' => 1850000,
        ]);

        ChiSoDienNuoc::create([
            'phong_id' => $phong->id,
            'loai' => 'dien',
            'thang' => 5,
            'nam' => 2026,
            'chi_so_cu' => 120,
            'chi_so_moi' => 150,
        ]);
        ChiSoDienNuoc::create([
            'phong_id' => $phong->id,
            'loai' => 'nuoc',
            'thang' => 5,
            'nam' => 2026,
            'chi_so_cu' => 10,
            'chi_so_moi' => 15,
        ]);

        Log::shouldReceive('info')
            ->once()
            ->withArgs(fn (string $message, array $context) =>
                $message === 'student_invoice_detail_viewed'
                && ($context['user_id'] ?? null) === $user->id
                && ($context['hoadon_id'] ?? null) === $hoadon->id
            );

        $response = $this->actingAs($user)->get(route('student.phongcuatoi.hoadon.chitiet', $hoadon->id));

        $response->assertOk();
        $response->assertSee('Chi tiết các khoản phí');
        $response->assertSee('Tiền phòng');
        $response->assertSee('Tiền điện');
        $response->assertSee('Tiền nước');
        $response->assertSee('Phí dịch vụ');
        $response->assertSee('Kỳ áp dụng: 5/2026');
        $response->assertSee('120 → 150');
        $response->assertSee('10 → 15');
    }

    public function test_student_invoice_detail_shows_empty_state_when_no_fee_items(): void
    {
        $user = User::factory()->sinhvien()->create();
        $sinhvien = Sinhvien::factory()->create(['user_id' => $user->id]);
        $phong = Phong::factory()->create();
        $giuong = Giuong::factory()->create(['phong_id' => $phong->id]);
        $hopdong = Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien->id,
            'phong_id' => $phong->id,
            'giuong_id' => $giuong->id,
            'trang_thai' => ContractStatus::Active,
        ]);

        $hoadon = Hoadon::factory()->create([
            'hopdong_id' => $hopdong->id,
            'phong_id' => $phong->id,
            'trang_thai' => InvoiceStatus::Unpaid,
            'ghi_chu' => 'Ky 5/2026',
            'tien_phong' => 0,
            'tien_dien' => 0,
            'tien_nuoc' => 0,
            'phi_dich_vu' => 0,
            'tong_tien' => 0,
        ]);

        $response = $this->actingAs($user)->get(route('student.phongcuatoi.hoadon.chitiet', $hoadon->id));

        $response->assertOk();
        $response->assertSee('Không có khoản phí nào để hiển thị.');
    }

    public function test_student_invoice_detail_handles_missing_period_and_meter_data(): void
    {
        $user = User::factory()->sinhvien()->create();
        $sinhvien = Sinhvien::factory()->create(['user_id' => $user->id]);
        $phong = Phong::factory()->create();
        $giuong = Giuong::factory()->create(['phong_id' => $phong->id]);
        $hopdong = Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien->id,
            'phong_id' => $phong->id,
            'giuong_id' => $giuong->id,
            'trang_thai' => ContractStatus::Active,
        ]);

        $hoadon = Hoadon::factory()->create([
            'hopdong_id' => $hopdong->id,
            'phong_id' => $phong->id,
            'trang_thai' => InvoiceStatus::Unpaid,
            'ghi_chu' => null,
            'tien_phong' => 1500000,
            'tien_dien' => 200000,
            'tien_nuoc' => 100000,
            'phi_dich_vu' => 50000,
            'tong_tien' => 1850000,
        ]);

        $response = $this->actingAs($user)->get(route('student.phongcuatoi.hoadon.chitiet', $hoadon->id));

        $response->assertOk();
        $response->assertSee('Chưa có chỉ số điện ghi nhận cho kỳ này.');
        $response->assertSee('Chưa có chỉ số nước ghi nhận cho kỳ này.');
    }
}
