<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ToaNha;
use App\Models\LoaiPhong;
use App\Models\Phong;
use App\Models\Giuong;
use App\Models\Sinhvien;
use App\Models\Admin;
use App\Enums\UserRole;
use App\Enums\Gender;
use App\Enums\BedStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Cấu hình hệ thống
        $this->call(CauhinhSeeder::class);

        // 1. Tạo Toà nhà
        $toaA = ToaNha::updateOrCreate(
            ['ma_toa_nha' => 'TOA_A'],
            [
                'ten_toa_nha' => 'Tòa Nhà A',
                'dia_chi' => 'Khu A, KTX Đại học',
                'mo_ta' => 'Tòa nhà dành cho sinh viên Nam',
            ]
        );

        $toaB = ToaNha::updateOrCreate(
            ['ma_toa_nha' => 'TOA_B'],
            [
                'ten_toa_nha' => 'Tòa Nhà B',
                'dia_chi' => 'Khu B, KTX Đại học',
                'mo_ta' => 'Tòa nhà dành cho sinh viên Nữ',
            ]
        );

        // 2. Tạo Loại phòng
        $standard4 = LoaiPhong::updateOrCreate(
            ['ten_loai' => 'Standard 4'],
            [
                'suc_chua' => 4,
                'gia_thang' => 500000,
                'tien_nghi' => ['wifi', 'quat_tran'],
            ]
        );

        $vip2 = LoaiPhong::updateOrCreate(
            ['ten_loai' => 'VIP 2'],
            [
                'suc_chua' => 2,
                'gia_thang' => 1200000,
                'tien_nghi' => ['wifi', 'quat_tran', 'dieu_hoa', 'nong_lanh'],
            ]
        );

        // 3. Tạo Admin
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@ktx.test'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('12345678'),
                'vaitro' => UserRole::Admin,
                'gender' => Gender::Male,
                'is_active' => true,
            ]
        );

        // 4. Tạo một số Phòng và Giường mẫu cho Tòa A
        for ($i = 1; $i <= 5; $i++) {
            $phong = Phong::updateOrCreate(
                [
                    'toa_nha_id' => $toaA->id,
                    'ten_phong' => 'A10' . $i,
                ],
                [
                    'loai_phong_id' => $standard4->id,
                    'tang' => 1,
                    'gioi_tinh_han_che' => Gender::Male,
                ]
            );

            for ($j = 1; $j <= 4; $j++) {
                Giuong::updateOrCreate(
                    [
                        'phong_id' => $phong->id,
                        'ma_giuong' => $phong->ten_phong . '-G' . $j,
                    ],
                    [
                        'trang_thai' => BedStatus::Available,
                    ]
                );
            }
        }

        // 5. Tạo Sinh viên mẫu
        $svUser = User::updateOrCreate(
            ['email' => 'sv1@ktx.test'],
            [
                'name' => 'Nguyễn Văn A',
                'password' => Hash::make('12345678'),
                'vaitro' => UserRole::SinhVien,
                'gender' => Gender::Male,
                'phone' => '0123456789',
                'is_active' => true,
            ]
        );

        Sinhvien::updateOrCreate(
            ['user_id' => $svUser->id],
            [
                'ma_sinh_vien' => 'SV0001',
                'lop' => 'CNTT-01',
            ]
        );
    }
}
