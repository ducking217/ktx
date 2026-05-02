<?php

namespace Database\Factories;

use App\Models\Dangky;
use App\Models\Phong;
use App\Enums\RegistrationStatus;
use App\Enums\RegistrationType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DangkyFactory extends Factory
{
    protected $model = Dangky::class;

    public function definition(): array
    {
        return [
            'phong_id' => Phong::factory(),
            'ho_ten' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'so_dien_thoai' => $this->faker->phoneNumber,
            'so_cccd' => $this->faker->numerify('############'),
            'lookup_token' => Str::random(32),
            'loaidangky' => $this->faker->randomElement(RegistrationType::cases()),
            'trangthai' => $this->faker->randomElement(RegistrationStatus::cases()),
        ];
    }
}
