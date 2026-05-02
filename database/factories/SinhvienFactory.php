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
            'masinhvien' => $this->faker->unique()->numerify('SV######'),
            'lop' => 'CNTT' . $this->faker->numberBetween(1, 4),
            'sodienthoai' => encrypt($this->faker->phoneNumber),
            'so_cccd' => encrypt($this->faker->numerify('############')),
            'phong_id' => Phong::factory(),
            'ngay_vao' => now(),
            'ngay_het_han' => now()->addMonths(6),
        ];
    }
}
