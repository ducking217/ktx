<?php

namespace Database\Factories;

use App\Models\Phong;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhongFactory extends Factory
{
    protected $model = Phong::class;

    public function definition(): array
    {
        return [
            'toa_nha_id' => \App\Models\ToaNha::factory(),
            'loai_phong_id' => \App\Models\LoaiPhong::factory(),
            'ten_phong' => 'P' . $this->faker->unique()->numberBetween(100, 999),
            'tang' => $this->faker->numberBetween(1, 10),
            'gioi_tinh_han_che' => \App\Enums\Gender::Any,
            'trang_thai' => 'active',
        ];
    }
}
