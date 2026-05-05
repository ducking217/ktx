<?php

namespace Database\Seeders;

use App\Models\Cauhinh;
use Illuminate\Database\Seeder;

class CauhinhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['ten' => 'phi_the_chan', 'giatri' => '1000000'],
            ['ten' => 'phi_dich_vu', 'giatri' => '50000'],
            ['ten' => 'don_gia_dien', 'giatri' => '3500'],
            ['ten' => 'don_gia_nuoc', 'giatri' => '15000'],
            ['ten' => 'ten_ky_tuc_xa', 'giatri' => 'Ký túc xá Đại học Phương Đông'],
            ['ten' => 'email_lien_he', 'giatri' => 'ktx@phuongdong.edu.vn'],
            ['ten' => 'so_dien_thoai_lien_he', 'giatri' => '024.3456.7890'],
        ];

        foreach ($settings as $setting) {
            Cauhinh::updateOrCreate(['ten' => $setting['ten']], $setting);
        }
    }
}
