<?php

namespace Database\Factories;

use App\Models\YeuCauGiaHan;
use App\Models\Hopdong;
use App\Models\Sinhvien;
use App\Enums\ExtensionStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class YeuCauGiaHanFactory extends Factory
{
    protected $model = YeuCauGiaHan::class;

    public function definition(): array
    {
        return [
            'hopdong_id' => Hopdong::factory(),
            'sinhvien_id' => Sinhvien::factory(),
            'ngay_ket_thuc_moi' => now()->addMonths(6)->format('Y-m-d'),
            'ly_do' => $this->faker->sentence(),
            'trang_thai' => ExtensionStatus::Pending->value,
            'ghi_chu_admin' => null,
        ];
    }
}
