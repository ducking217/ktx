<?php

namespace Database\Seeders;

use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\User;
use Illuminate\Database\Seeder;

class SinhvienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phongdau = Phong::all()->first();

        $sv1 = User::where('email', 'sv1@ktx.test')->first();
        $sv2 = User::where('email', 'sv2@ktx.test')->first();
        $sv3 = User::where('email', 'sv3@ktx.test')->first();
        $sv4 = User::where('email', 'sv4@ktx.test')->first();
        $sv5 = User::where('email', 'sv5@ktx.test')->first();

        if ($sv1) {
            $sv1->update(['phone' => '0900000001']);
            Sinhvien::updateOrCreate(
                ['user_id' => $sv1->id],
                [
                    'ma_sinh_vien' => 'sv0001',
                    'lop' => 'ctk42',
                    'phong_id' => $phongdau?->id,
                ]
            );
        }

        if ($sv2) {
            $sv2->update(['phone' => '0900000002']);
            Sinhvien::updateOrCreate(
                ['user_id' => $sv2->id],
                [
                    'ma_sinh_vien' => 'sv0002',
                    'lop' => 'ctk42',
                    'phong_id' => null,
                ]
            );
        }

        if ($sv3) {
            $sv3->update(['phone' => '0900000003']);
            Sinhvien::updateOrCreate(
                ['user_id' => $sv3->id],
                [
                    'ma_sinh_vien' => 'sv0003',
                    'lop' => 'ctk43',
                    'phong_id' => null,
                ]
            );
        }

        if ($sv4) {
            $sv4->update(['phone' => '0900000004']);
            Sinhvien::updateOrCreate(
                ['user_id' => $sv4->id],
                [
                    'ma_sinh_vien' => 'sv0004',
                    'lop' => 'ctk43',
                    'phong_id' => null,
                ]
            );
        }

        if ($sv5) {
            $sv5->update(['phone' => '0900000005']);
            Sinhvien::updateOrCreate(
                ['user_id' => $sv5->id],
                [
                    'ma_sinh_vien' => 'sv0005',
                    'lop' => 'ctk44',
                    'phong_id' => null,
                ]
            );
        }
    }
}
