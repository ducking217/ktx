<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Test 1: Creating Hoadon with unpaid status ===" . PHP_EOL;

// First check if we have any existing hopdong to reference
$hopdong = \App\Models\Hopdong::first();
if (!$hopdong) {
    echo 'No existing hopdong found. Creating test data first...' . PHP_EOL;
    // Create minimal test data
    $phong = \App\Models\Phong::first();
    if (!$phong) {
        echo 'No phong found. Please create test data first.' . PHP_EOL;
        exit(1);
    }
    $sinhvien = \App\Models\Sinhvien::first();
    if (!$sinhvien) {
        echo 'No sinhvien found. Please create test data first.' . PHP_EOL;
        exit(1);
    }
    $hopdong = \App\Models\Hopdong::create([
        'sinhvien_id' => $sinhvien->id,
        'phong_id' => $phong->id,
        'giuong_id' => 1,
        'ngay_bat_dau' => now()->toDateString(),
        'ngay_ket_thuc' => now()->addMonths(6)->toDateString(),
        'gia_thuc_te' => 500000,
        'trang_thai' => 'active'
    ]);
}

echo 'Using hopdong_id: ' . $hopdong->id . PHP_EOL;

// Create Hoadon with proper data
$hoadon = \App\Models\Hoadon::create([
    'hopdong_id' => $hopdong->id,
    'phong_id' => $hopdong->phong_id,
    'ma_hoa_don' => 'TEST-' . strtoupper(\Illuminate\Support\Str::random(8)),
    'loai_hoadon' => 'monthly',
    'tien_phong' => 500000,
    'tien_dien' => 150000,
    'tien_nuoc' => 100000,
    'phi_dich_vu' => 50000,
    'tong_tien' => 800000,
    'trang_thai' => 'unpaid',
    'ngay_het_han' => now()->addDays(7)->toDateString(),
    'ghi_chu' => 'Test invoice from verification script'
]);

echo 'Created Hoadon ID: ' . $hoadon->id . PHP_EOL;
echo 'Invoice code: ' . $hoadon->ma_hoa_don . PHP_EOL;
echo 'Status: ' . $hoadon->trang_thai->value . PHP_EOL;
echo 'Total amount: ' . $hoadon->tong_tien . PHP_EOL;

echo PHP_EOL . "=== Test 2: Verify tong_tien constraint ===" . PHP_EOL;
$expectedTotal = $hoadon->tien_phong + $hoadon->tien_dien + $hoadon->tien_nuoc + $hoadon->phi_dich_vu;
echo 'Expected total (sum of components): ' . $expectedTotal . PHP_EOL;
echo 'Actual tong_tien in DB: ' . $hoadon->tong_tien . PHP_EOL;
echo 'Constraint satisfied: ' . ($expectedTotal == $hoadon->tong_tien ? 'YES' : 'NO') . PHP_EOL;

echo PHP_EOL . "=== Test 3: Test paid status constraint without ngay_thanh_toan ===" . PHP_EOL;
try {
    $hoadon->update(['trang_thai' => 'paid']);
    echo 'ERROR: DB should have blocked this update! Constraint not working.' . PHP_EOL;
} catch (\Exception $e) {
    echo 'SUCCESS: DB constraint blocked the update as expected.' . PHP_EOL;
    echo 'Error message: ' . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== Test 4: Test proper transition to paid with ngay_thanh_toan ===" . PHP_EOL;
try {
    $success = $hoadon->transitionTo('paid');
    echo 'Transition successful: ' . ($success ? 'YES' : 'NO') . PHP_EOL;
    echo 'New status: ' . $hoadon->fresh()->trang_thai->value . PHP_EOL;
    echo 'Payment date: ' . $hoadon->fresh()->ngay_thanh_toan . PHP_EOL;
} catch (\Exception $e) {
    echo 'Error during transition: ' . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== Test 5: Try to violate tong_tien constraint manually ===" . PHP_EOL;
try {
    $hoadon->update(['tong_tien' => 999999]);
    echo 'ERROR: DB should have blocked this invalid tong_tien!' . PHP_EOL;
} catch (\Exception $e) {
    echo 'SUCCESS: DB constraint blocked invalid tong_tien update.' . PHP_EOL;
    echo 'Error message: ' . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== All Tests Completed ===" . PHP_EOL;
