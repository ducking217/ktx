<?php

namespace Database\Factories;

use App\Models\LoaiPhong;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoaiPhongFactory extends Factory
{
    protected $model = LoaiPhong::class;

    public function definition(): array
    {
        return [
            'ten_loai' => $this->faker->unique()->word() . ' ' . $this->faker->numberBetween(1, 10),
            'suc_chua' => $this->faker->randomElement([4, 6, 8]),
            'gia_thang' => $this->faker->randomElement([1200000, 1500000, 2000000]),
            'tien_nghi' => ['wifi', 'dieu_hoa'],
        ];
    }
}
