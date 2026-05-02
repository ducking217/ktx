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
        return [
            'phong_id' => Phong::factory(),
            'sinhvien_id' => Sinhvien::factory(),
            'thang' => now()->month,
            'nam' => now()->year,
            'chisodiencu' => 100,
            'chisodienmoi' => 150,
            'chisonuoccu' => 50,
            'chisonuocmoi' => 60,
            'tienphong' => 1500000,
            'tiendien' => 175000,
            'tiennuoc' => 150000,
            'phidichvu' => 50000,
            'tongtien' => 1875000,
            'trangthaithanhtoan' => InvoiceStatus::Pending,
            'ngayxuat' => now()->format('Y-m-d'),
            'loai_hoadon' => Hoadon::LOAI_MONTHLY,
        ];
    }
}
