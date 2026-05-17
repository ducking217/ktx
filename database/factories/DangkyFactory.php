<?php

namespace Database\Factories;

use App\Models\Dangky;
use App\Enums\RegistrationStatus;
use App\Models\LoaiPhong;
use App\Models\ToaNha;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DangkyFactory extends Factory
{
    protected $model = Dangky::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'ho_ten' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_encrypted' => encrypt($this->faker->phoneNumber()),
            'id_card_encrypted' => encrypt($this->faker->numerify('############')),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'dob' => $this->faker->date(),
            'toa_nha_id' => ToaNha::factory(),
            'loai_phong_id' => LoaiPhong::factory(),
            'phong_id' => null,
            'lookup_token' => Str::random(32),
            'token_expires_at' => now()->addDays(30),
            'trang_thai' => RegistrationStatus::Pending,
        ];
    }
}
