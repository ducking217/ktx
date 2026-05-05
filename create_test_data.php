<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Creating Minimal Test Data for Hoadon Tests ===" . PHP_EOL;

// 1. Create Toa Nha
$toaNha = \App\Models\ToaNha::firstOrCreate([
    'ten_toa_nha' => 'Tòa A Test'
], [
    'ma_toa_nha' => 'TA',
    'dia_chi' => 'Địa chỉ test',
    'mo_ta' => 'Tòa nhà test cho verification'
]);

echo "Created ToaNha ID: {$toaNha->id}" . PHP_EOL;

// 2. Create Loai Phong
$loaiPhong = \App\Models\LoaiPhong::firstOrCreate([
    'ten_loai' => 'Phòng 4 người Test'
], [
    'suc_chua' => 4,
    'gia_thang' => 500000,
    'tien_nghi' => json_encode(['dieu_hoa', 'wifi'])
]);

echo "Created LoaiPhong ID: {$loaiPhong->id}" . PHP_EOL;

// 3. Create Phong
$phong = \App\Models\Phong::firstOrCreate([
    'ten_phong' => 'A101 Test'
], [
    'toa_nha_id' => $toaNha->id,
    'loai_phong_id' => $loaiPhong->id,
    'tang' => 1,
    'trang_thai' => 'active'
]);

echo "Created Phong ID: {$phong->id}" . PHP_EOL;

// 4. Create Giuong
$giuong = \App\Models\Giuong::firstOrCreate([
    'phong_id' => $phong->id,
    'ma_giuong' => 'A101-G1'
], [
    'trang_thai' => 'available'
]);

echo "Created Giuong ID: {$giuong->id}" . PHP_EOL;

// 5. Get or create User for Sinhvien
$user = \App\Models\User::first();
if (!$user) {
    $user = \App\Models\User::create([
        'name' => 'Test Student',
        'email' => 'test@student.com',
        'password' => bcrypt('password')
    ]);
}

echo "Using User ID: {$user->id}" . PHP_EOL;

// 6. Create Sinhvien
$sinhvien = \App\Models\Sinhvien::firstOrCreate([
    'user_id' => $user->id
], [
    'ma_sinh_vien' => 'SV' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
    'ho_ten' => 'Test Student',
    'ngay_sinh' => '2000-01-01',
    'gioi_tinh' => 'nam',
    'dien_thoai' => '0123456789',
    'que_quan' => 'Test Province'
]);

echo "Created Sinhvien ID: {$sinhvien->id}" . PHP_EOL;

// 7. Create Hopdong
$hopdong = \App\Models\Hopdong::create([
    'sinhvien_id' => $sinhvien->id,
    'phong_id' => $phong->id,
    'giuong_id' => $giuong->id,
    'ngay_bat_dau' => now()->toDateString(),
    'ngay_ket_thuc' => now()->addMonths(6)->toDateString(),
    'gia_thuc_te' => 500000,
    'trang_thai' => 'active'
]);

echo "Created Hopdong ID: {$hopdong->id}" . PHP_EOL;

// 8. Update giuong status to occupied
$giuong->update(['trang_thai' => 'occupied']);

echo PHP_EOL . "=== Test Data Created Successfully ===" . PHP_EOL;
echo "Ready to run Hoadon constraint tests!" . PHP_EOL;
