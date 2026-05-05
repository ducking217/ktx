<?php

namespace Database\Seeders;

use App\Models\Kyluat;
use App\Models\Sinhvien;
use App\Enums\DisciplineLevel;
use Illuminate\Database\Seeder;

class KyLuatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sinhVien = Sinhvien::first();

        if ($sinhVien) {
            Kyluat::create([
                'sinhvien_id' => $sinhVien->id,
                'noi_dung' => 'Sử dụng thiết bị điện công suất lớn trái quy định (Bếp điện)',
                'ngay_vi_pham' => now()->subDays(5),
                'muc_do' => DisciplineLevel::Medium->value,
            ]);

            Kyluat::create([
                'sinhvien_id' => $sinhVien->id,
                'noi_dung' => 'Về muộn sau 23h không có lý do chính đáng',
                'ngay_vi_pham' => now()->subDays(2),
                'muc_do' => DisciplineLevel::Low->value,
            ]);
        }
    }
}
