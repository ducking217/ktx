<?php

namespace Database\Factories;

use App\Models\Hopdong;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Enums\ContractStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class HopdongFactory extends Factory
{
    protected $model = Hopdong::class;

    public function definition(): array
    {
        return [
            'sinhvien_id' => Sinhvien::factory(),
            'phong_id' => Phong::factory(),
            'giuong_id' => \App\Models\Giuong::factory(),
            'ngay_bat_dau' => now(),
            'ngay_ket_thuc' => now()->addMonths(6),
            'gia_thuc_te' => 1500000,
            'tien_coc' => 1000000,
            'trang_thai' => ContractStatus::Active,
        ];
    }
}
