<?php

namespace Database\Factories;

use App\Models\Hoadon;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class HoadonFactory extends Factory
{
    protected $model = Hoadon::class;

    public function definition(): array
    {
        $tienPhong = 1500000;
        $tienDien = 175000;
        $tienNuoc = 150000;
        $phiDichVu = 50000;
        $tongTien = $tienPhong + $tienDien + $tienNuoc + $phiDichVu;
        $status = $this->faker->randomElement([InvoiceStatus::Unpaid, InvoiceStatus::Paid]);

        return [
            'hopdong_id' => \App\Models\Hopdong::factory(),
            'phong_id' => Phong::factory(),
            'ma_hoa_don' => $this->faker->unique()->bothify('HD-#####'),
            'loai_hoadon' => 'monthly',
            'tien_phong' => $tienPhong,
            'tien_dien' => $tienDien,
            'tien_nuoc' => $tienNuoc,
            'phi_dich_vu' => $phiDichVu,
            'tong_tien' => $tongTien,
            'trang_thai' => $status,
            'ngay_thanh_toan' => $status === InvoiceStatus::Paid ? now()->toDateString() : null,
            'ngay_het_han' => now()->addDays(15),
        ];
    }
}
