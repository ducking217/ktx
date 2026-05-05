<?php

namespace Database\Factories;

use App\Models\Giuong;
use App\Models\Phong;
use App\Enums\BedStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class GiuongFactory extends Factory
{
    protected $model = Giuong::class;

    public function definition(): array
    {
        return [
            'phong_id' => Phong::factory(),
            'ma_giuong' => $this->faker->unique()->bothify('P###-G#'),
            'trang_thai' => BedStatus::Available,
        ];
    }
}
