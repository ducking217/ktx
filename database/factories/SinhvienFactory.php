<?php

namespace Database\Factories;

use App\Models\Sinhvien;
use App\Models\User;
use App\Models\Phong;
use Illuminate\Database\Eloquent\Factories\Factory;

class SinhvienFactory extends Factory
{
    protected $model = Sinhvien::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'ma_sinh_vien' => $this->faker->unique()->numerify('SV######'),
            'lop' => 'CNTT' . $this->faker->numberBetween(1, 4),
            'khoa' => 'CNTT',
            'ngay_nhap_hoc' => now(),
        ];
    }
}
