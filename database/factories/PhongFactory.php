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
            'tenphong' => 'P' . $this->faker->unique()->numberBetween(100, 999),
            'tang' => $this->faker->numberBetween(1, 10),
            'giaphong' => $this->faker->randomElement([1200000, 1500000, 2000000]),
            'succhuamax' => 8,
            'dango' => 0,
            'gioitinh' => $this->faker->randomElement(['nam', 'nu']),
        ];
    }
}
