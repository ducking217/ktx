<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ktx.test'],
            [
                'name' => 'admin',
                'password' => Hash::make('12345678'),
                'vaitro' => 'admin',
                'gender' => 'male',
            ]
        );

        User::updateOrCreate(
            ['email' => 'sv1@ktx.test'],
            [
                'name' => 'sinhvien 1',
                'password' => Hash::make('12345678'),
                'vaitro' => 'sinhvien',
                'gender' => 'male',
                'phone' => '0900000001',
            ]
        );
        User::updateOrCreate(
            ['email' => 'sv2@ktx.test'],
            [
                'name' => 'sinhvien 2',
                'password' => Hash::make('12345678'),
                'vaitro' => 'sinhvien',
                'gender' => 'female',
                'phone' => '0900000002',
            ]
        );
        User::updateOrCreate(
            ['email' => 'sv3@ktx.test'],
            [
                'name' => 'sinhvien 3',
                'password' => Hash::make('12345678'),
                'vaitro' => 'sinhvien',
                'gender' => 'male',
                'phone' => '0900000003',
            ]
        );
        User::updateOrCreate(
            ['email' => 'sv4@ktx.test'],
            [
                'name' => 'sinhvien 4',
                'password' => Hash::make('12345678'),
                'vaitro' => 'sinhvien',
                'gender' => 'female',
                'phone' => '0900000004',
            ]
        );
        User::updateOrCreate(
            ['email' => 'sv5@ktx.test'],
            [
                'name' => 'sinhvien 5',
                'password' => Hash::make('12345678'),
                'vaitro' => 'sinhvien',
                'gender' => 'male',
                'phone' => '0900000005',
            ]
        );
    }
}
