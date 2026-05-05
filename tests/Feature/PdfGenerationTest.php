<?php

namespace Tests\Feature;

use App\Models\Hoadon;
use App\Models\Hopdong;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\User;
use App\Models\ToaNha;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PdfGenerationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // DomPDF configuration for testing environment
        config(['dompdf.options.chroot' => public_path()]);
        config(['dompdf.options.isHtml5ParserEnabled' => true]);
    }

    /**
     * test_download_pdf_hopdong_tra_ve_file_pdf
     */
    public function test_download_pdf_hopdong_tra_ve_file_pdf(): void
    {
        // Setup: tạo Admin
        $admin = User::factory()->superAdmin()->create();

        // Setup: tạo ToaNha
        $toaNha = ToaNha::factory()->create();

        // Setup: tạo Phong
        $phong = Phong::factory()->create(['toa_nha_id' => $toaNha->id]);

        // Setup: tạo Sinhvien và User định danh
        $user = User::factory()->sinhvien()->create();
        $sinhvien = Sinhvien::factory()->create([
            'user_id' => $user->id,
        ]);

        // Setup: tạo Hopdong với đầy đủ relations
        $giuong = \App\Models\Giuong::factory()->create(['phong_id' => $phong->id]);
        $hopdong = Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien->id,
            'phong_id' => $phong->id,
            'giuong_id' => $giuong->id,
        ]);

        // Action: GET /admin/hopdong/{id}/pdf
        $response = $this->actingAs($admin)
            ->get(route('admin.hopdong.pdf', $hopdong->id));

        // Assert: response->assertOk()
        $response->assertOk();

        // Assert: response->assertHeader('Content-Type', 'application/pdf')
        $response->assertHeader('Content-Type', 'application/pdf');

        // Assert: strlen(response->content()) > 1000 (file có nội dung thực, không rỗng)
        $this->assertGreaterThan(1000, strlen($response->content()));
    }

    /**
     * test_download_pdf_hoadon_tra_ve_file_pdf
     */
    public function test_download_pdf_hoadon_tra_ve_file_pdf(): void
    {
        // Setup: tạo Admin
        $admin = User::factory()->superAdmin()->create();

        // Setup: tạo ToaNha
        $toaNha = ToaNha::factory()->create();

        // Setup: tạo Phong
        $phong = Phong::factory()->create(['toa_nha_id' => $toaNha->id]);

        // Setup: tạo Sinhvien và User định danh
        $user = User::factory()->sinhvien()->create();
        $sinhvien = Sinhvien::factory()->create([
            'user_id' => $user->id,
        ]);

        // Setup: tạo Hoadon với đầy đủ relations
        $giuong = \App\Models\Giuong::factory()->create(['phong_id' => $phong->id]);
        $hopdong = Hopdong::factory()->create([
            'sinhvien_id' => $sinhvien->id,
            'phong_id' => $phong->id,
            'giuong_id' => $giuong->id,
        ]);

        $hoadon = Hoadon::factory()->create([
            'hopdong_id' => $hopdong->id,
            'phong_id' => $phong->id,
        ]);

        // Action: GET /admin/hoadon/{id}/pdf
        $response = $this->actingAs($admin)
            ->get(route('admin.hoadon.pdf', $hoadon->id));

        // Assert: response->assertOk()
        $response->assertOk();

        // Assert: response->assertHeader('Content-Type', 'application/pdf')
        $response->assertHeader('Content-Type', 'application/pdf');

        // Assert: strlen(response->content()) > 1000 (file có nội dung thực, không rỗng)
        $this->assertGreaterThan(1000, strlen($response->content()));
    }
}
