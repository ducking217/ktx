<?php

namespace Database\Factories;

use App\Models\ToaNha;
use Illuminate\Database\Eloquent\Factories\Factory;

class ToaNhaFactory extends Factory
{
    protected $model = ToaNha::class;

    public function definition(): array
    {
        return [
            'ten_toa_nha' => 'Tòa ' . $this->faker->unique()->lexify('??'),
            'ma_toa_nha' => $this->faker->unique()->lexify('????'),
            'mo_ta' => $this->faker->sentence(),
        ];
    }
}
