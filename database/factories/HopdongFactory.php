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
            'ngay_bat_dau' => now(),
            'ngay_ket_thuc' => now()->addMonths(6),
            'giaphong_luc_ky' => 1500000,
            'trang_thai' => ContractStatus::Active,
        ];
    }
}
