<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ToaNha;
use App\Models\LoaiPhong;
use App\Models\Phong;
use App\Models\Giuong;
use App\Models\Sinhvien;
use App\Models\Hopdong;
use App\Models\Hoadon;
use App\Models\ThanhToan;
use App\Models\ChiSoDienNuoc;
use App\Models\YeuCauGiaHan;
use App\Models\Thongbao;
use App\Models\Lienhe;
use App\Models\Kyluat;
use App\Models\Taisan;
use App\Models\Vattu;
use App\Models\Lichsubaotri;
use App\Models\Dangky;
use App\Models\Baohong;
use App\Enums\UserRole;
use App\Enums\Gender;
use App\Enums\BedStatus;
use App\Enums\ContractStatus;
use App\Enums\InvoiceStatus;
use App\Enums\RegistrationStatus;
use App\Enums\BaohongStatus;
use App\Enums\DisciplineLevel;
use App\Enums\ExtensionStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Cấu hình hệ thống
        $this->call(CauhinhSeeder::class);

        // 1. Tạo Toà nhà (cố định 2 tòa A/B)
        $toaA = ToaNha::where('ma_toa_nha', 'A')->first() ?? ToaNha::where('ma_toa_nha', 'TOA_A')->first();
        if ($toaA) {
            if ($toaA->ma_toa_nha !== 'A') {
                $toaA->update(['ma_toa_nha' => 'A']);
            }
        } else {
            $toaA = ToaNha::create(['ma_toa_nha' => 'A', 'ten_toa_nha' => 'Tòa A', 'gioi_tinh' => Gender::Male]);
        }

        $toaA->update([
            'ten_toa_nha' => 'Tòa A',
            'gioi_tinh' => Gender::Male,
            'dia_chi' => 'Khu A, KTX Đại học',
            'mo_ta' => 'Tòa nhà dành cho sinh viên Nam',
            'so_tang' => 3,
            'so_phong' => 12,
        ]);

        $toaB = ToaNha::where('ma_toa_nha', 'B')->first() ?? ToaNha::where('ma_toa_nha', 'TOA_B')->first();
        if ($toaB) {
            if ($toaB->ma_toa_nha !== 'B') {
                $toaB->update(['ma_toa_nha' => 'B']);
            }
        } else {
            $toaB = ToaNha::create(['ma_toa_nha' => 'B', 'ten_toa_nha' => 'Tòa B', 'gioi_tinh' => Gender::Female]);
        }

        $toaB->update([
            'ten_toa_nha' => 'Tòa B',
            'gioi_tinh' => Gender::Female,
            'dia_chi' => 'Khu B, KTX Đại học',
            'mo_ta' => 'Tòa nhà dành cho sinh viên Nữ',
            'so_tang' => 3,
            'so_phong' => 12,
        ]);

        $toaAIds = ToaNha::query()->whereIn('ma_toa_nha', ['A', 'TOA_A'])->pluck('id')->all();
        $toaBIds = ToaNha::query()->whereIn('ma_toa_nha', ['B', 'TOA_B'])->pluck('id')->all();

        if (!empty($toaAIds)) {
            Phong::query()->whereIn('toa_nha_id', $toaAIds)->update(['toa_nha_id' => $toaA->id]);
            if (Schema::hasTable('dangky') && Schema::hasColumn('dangky', 'toa_nha_id')) {
                DB::table('dangky')->whereIn('toa_nha_id', $toaAIds)->update(['toa_nha_id' => $toaA->id]);
            }
            if (Schema::hasTable('users') && Schema::hasColumn('users', 'toa_nha_id')) {
                DB::table('users')->whereIn('toa_nha_id', $toaAIds)->update(['toa_nha_id' => $toaA->id]);
            }
        }

        if (!empty($toaBIds)) {
            Phong::query()->whereIn('toa_nha_id', $toaBIds)->update(['toa_nha_id' => $toaB->id]);
            if (Schema::hasTable('dangky') && Schema::hasColumn('dangky', 'toa_nha_id')) {
                DB::table('dangky')->whereIn('toa_nha_id', $toaBIds)->update(['toa_nha_id' => $toaB->id]);
            }
            if (Schema::hasTable('users') && Schema::hasColumn('users', 'toa_nha_id')) {
                DB::table('users')->whereIn('toa_nha_id', $toaBIds)->update(['toa_nha_id' => $toaB->id]);
            }
        }

        $toaCList = ToaNha::query()
            ->whereIn('ma_toa_nha', ['C', 'TOA_C'])
            ->orWhereIn('ten_toa_nha', ['Tòa C', 'Tòa Nhà C'])
            ->get();

        foreach ($toaCList as $toaC) {
            if (Schema::hasTable('users') && Schema::hasColumn('users', 'toa_nha_id')) {
                DB::table('users')->where('toa_nha_id', $toaC->id)->update(['toa_nha_id' => null]);
            }
            if (Schema::hasTable('dangky') && Schema::hasColumn('dangky', 'toa_nha_id')) {
                DB::table('dangky')->where('toa_nha_id', $toaC->id)->delete();
            }
            $toaC->delete();
        }

        // 2. Tạo Loại phòng
        $roomType = LoaiPhong::updateOrCreate(
            ['ten_loai' => 'Phòng 6'],
            [
                'suc_chua' => 6,
                'gia_thang' => 500000,
                'tien_nghi' => ['wifi', 'quat_tran'],
            ]
        );

        Phong::query()->update(['loai_phong_id' => $roomType->id]);
        if (Schema::hasTable('dangky') && Schema::hasColumn('dangky', 'loai_phong_id')) {
            DB::table('dangky')->update(['loai_phong_id' => $roomType->id]);
        }

        LoaiPhong::query()
            ->where('id', '!=', $roomType->id)
            ->doesntHave('phongs')
            ->delete();

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

        // 4. Tạo cấu trúc phòng cố định (2 tòa A/B, mỗi tòa 3 tầng, mỗi tầng 4 phòng)
        $spec = [
            ['toa' => $toaA, 'code' => 'A', 'gender' => Gender::Male],
            ['toa' => $toaB, 'code' => 'B', 'gender' => Gender::Female],
        ];

        foreach ($spec as $item) {
            /** @var ToaNha $toa */
            $toa = $item['toa'];
            $code = (string) $item['code'];
            $gioiTinhHanChe = $item['gender'];

            $prefix = 'TOA_' . $code;
            $roomsToNormalize = Phong::query()
                ->where('toa_nha_id', $toa->id)
                ->where('ten_phong', 'like', $prefix . '%')
                ->get();

            foreach ($roomsToNormalize as $room) {
                $oldTenPhong = (string) $room->ten_phong;
                $suffix = substr($oldTenPhong, strlen($prefix));
                $newTenPhong = $code . $suffix;

                if ($newTenPhong !== $oldTenPhong) {
                    $exists = Phong::query()
                        ->where('toa_nha_id', $toa->id)
                        ->where('ten_phong', $newTenPhong)
                        ->exists();

                    if (! $exists) {
                        $room->update(['ten_phong' => $newTenPhong]);
                        foreach ($room->giuongs()->get() as $bed) {
                            if (preg_match('/-G(\d+)$/', (string) $bed->ma_giuong, $m)) {
                                $n = (int) $m[1];
                                $bed->update(['ma_giuong' => $newTenPhong . '-G' . $n]);
                            }
                        }
                    }
                }
            }

            Phong::query()
                ->where('toa_nha_id', $toa->id)
                ->update([
                    'loai_phong_id' => $roomType->id,
                    'gioi_tinh_han_che' => $gioiTinhHanChe,
                ]);

            $validRoomNames = [];
            for ($t = 1; $t <= 3; $t++) {
                for ($k = 1; $k <= 4; $k++) {
                    $validRoomNames[] = $code . $t . str_pad((string) $k, 2, '0', STR_PAD_LEFT);
                }
            }

            Phong::query()
                ->where('toa_nha_id', $toa->id)
                ->whereNotIn('ten_phong', $validRoomNames)
                ->get()
                ->each
                ->delete();

            for ($tang = 1; $tang <= 3; $tang++) {
                for ($i = 1; $i <= 4; $i++) {
                    $tenPhong = $code . $tang . str_pad((string) $i, 2, '0', STR_PAD_LEFT);

                    $phong = Phong::updateOrCreate(
                        [
                            'toa_nha_id' => $toa->id,
                            'ten_phong' => $tenPhong,
                        ],
                        [
                            'loai_phong_id' => $roomType->id,
                            'tang' => $tang,
                            'gioi_tinh_han_che' => $gioiTinhHanChe,
                            'trang_thai' => 'active',
                        ]
                    );

                    $soGiuong = (int) ($roomType->suc_chua ?? 0);
                    $existingBeds = $phong->giuongs()->get();
                    $existingNumbers = [];
                    foreach ($existingBeds as $bed) {
                        if (preg_match('/-G(\d+)$/', (string) $bed->ma_giuong, $m)) {
                            $n = (int) $m[1];
                            $existingNumbers[$n] = $bed;
                        }
                    }

                    for ($j = 1; $j <= $soGiuong; $j++) {
                        $bedCode = $phong->ten_phong . '-G' . $j;
                        if (isset($existingNumbers[$j])) {
                            $bed = $existingNumbers[$j];
                            if ((string) $bed->ma_giuong !== $bedCode) {
                                $bed->update(['ma_giuong' => $bedCode]);
                            }
                            continue;
                        }

                        Giuong::updateOrCreate(
                            [
                                'phong_id' => $phong->id,
                                'ma_giuong' => $bedCode,
                            ],
                            [
                                'trang_thai' => BedStatus::Available,
                            ]
                        );
                    }
                }
            }
        }

        // 5. Tạo Sinh viên mẫu
        $svUser = User::updateOrCreate(
            ['email' => 'sv1@ktx.test'],
            [
                'name' => 'Nguyễn Văn A',
                'password' => Hash::make('12345678'),
                'vaitro' => UserRole::Student,
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

        $students = [
            ['email' => 'sv2@ktx.test', 'name' => 'Trần Thị B', 'gender' => Gender::Female, 'phone' => '0900000002', 'ma' => 'SV0002', 'lop' => 'QTKD-02'],
            ['email' => 'sv3@ktx.test', 'name' => 'Lê Văn C', 'gender' => Gender::Male, 'phone' => '0900000003', 'ma' => 'SV0003', 'lop' => 'CNTT-02'],
            ['email' => 'sv4@ktx.test', 'name' => 'Phạm Thị D', 'gender' => Gender::Female, 'phone' => '0900000004', 'ma' => 'SV0004', 'lop' => 'KTPM-01'],
            ['email' => 'sv5@ktx.test', 'name' => 'Hoàng Văn E', 'gender' => Gender::Male, 'phone' => '0900000005', 'ma' => 'SV0005', 'lop' => 'KT-01'],
            ['email' => 'sv6@ktx.test', 'name' => 'Ngô Thị F', 'gender' => Gender::Female, 'phone' => '0900000006', 'ma' => 'SV0006', 'lop' => 'CNTT-03'],
            ['email' => 'sv7@ktx.test', 'name' => 'Đỗ Văn G', 'gender' => Gender::Male, 'phone' => '0900000007', 'ma' => 'SV0007', 'lop' => 'CNTT-04'],
        ];

        foreach ($students as $student) {
            $user = User::updateOrCreate(
                ['email' => $student['email']],
                [
                    'name' => $student['name'],
                    'password' => Hash::make('12345678'),
                    'vaitro' => UserRole::Student,
                    'gender' => $student['gender'],
                    'phone' => $student['phone'],
                    'is_active' => true,
                ]
            );

            Sinhvien::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'ma_sinh_vien' => $student['ma'],
                    'lop' => $student['lop'],
                ]
            );
        }

        $guests = [
            ['email' => 'guest1@ktx.test', 'name' => 'Guest One', 'gender' => Gender::Male, 'phone' => '0911111111', 'cccd' => '012345678901', 'status' => RegistrationStatus::Pending],
            ['email' => 'guest2@ktx.test', 'name' => 'Guest Two', 'gender' => Gender::Female, 'phone' => '0922222222', 'cccd' => '012345678902', 'status' => RegistrationStatus::ApprovedPendingPayment],
            ['email' => 'guest3@ktx.test', 'name' => 'Guest Three', 'gender' => Gender::Male, 'phone' => '0933333333', 'cccd' => '012345678903', 'status' => RegistrationStatus::Rejected],
        ];

        foreach ($guests as $guest) {
            $user = User::updateOrCreate(
                ['email' => $guest['email']],
                [
                    'name' => $guest['name'],
                    'password' => Hash::make('12345678'),
                    'vaitro' => UserRole::Guest,
                    'gender' => $guest['gender'],
                    'phone' => $guest['phone'],
                    'is_active' => true,
                ]
            );

            Dangky::create([
                'user_id' => $user->id,
                'ho_ten' => $user->name,
                'email' => $user->email,
                'phone_encrypted' => encrypt($guest['phone']),
                'id_card_encrypted' => encrypt($guest['cccd']),
                'gender' => $guest['gender']->value,
                'dob' => now()->subYears(19)->toDateString(),
                'toa_nha_id' => $guest['gender'] === Gender::Female ? $toaB->id : $toaA->id,
                'loai_phong_id' => $roomType->id,
                'phong_id' => null,
                'lookup_token' => Str::random(32),
                'token_expires_at' => now()->addDays(30),
                'trang_thai' => $guest['status'],
                'ghi_chu' => $guest['status'] === RegistrationStatus::Rejected ? 'Thiếu giấy tờ hợp lệ.' : null,
            ]);
        }

        $assignments = [
            ['email' => 'sv1@ktx.test', 'room' => 'A101'],
            ['email' => 'sv3@ktx.test', 'room' => 'A101'],
            ['email' => 'sv5@ktx.test', 'room' => 'A102'],
            ['email' => 'sv7@ktx.test', 'room' => 'A102'],
            ['email' => 'sv2@ktx.test', 'room' => 'B101'],
            ['email' => 'sv4@ktx.test', 'room' => 'B101'],
            ['email' => 'sv6@ktx.test', 'room' => 'B102'],
        ];

        $hopdongs = [];
        foreach ($assignments as $assignment) {
            $user = User::where('email', $assignment['email'])->first();
            if (! $user?->sinhvien) {
                continue;
            }

            $phong = Phong::where('ten_phong', $assignment['room'])->first();
            if (! $phong) {
                continue;
            }

            $giuong = Giuong::query()
                ->where('phong_id', $phong->id)
                ->where('trang_thai', BedStatus::Available)
                ->orderBy('id')
                ->first();

            if (! $giuong) {
                continue;
            }

            $giuong->update(['trang_thai' => BedStatus::Occupied]);

            $ngayBatDau = now()->subMonths(2)->startOfMonth();
            $ngayKetThuc = (clone $ngayBatDau)->addMonths(6)->endOfMonth();

            $hopdong = Hopdong::create([
                'sinhvien_id' => $user->sinhvien->id,
                'phong_id' => $phong->id,
                'giuong_id' => $giuong->id,
                'ngay_bat_dau' => $ngayBatDau->toDateString(),
                'ngay_ket_thuc' => $ngayKetThuc->toDateString(),
                'gia_thuc_te' => (int) ($roomType->gia_thang ?? 500000),
                'tien_coc' => 1000000,
                'trang_thai' => ContractStatus::Active,
                'ghi_chu' => null,
            ]);

            $hopdongs[] = $hopdong;
        }

        foreach ($hopdongs as $hopdong) {
            $tienPhong = (int) ($hopdong->gia_thuc_te ?? 0);
            $tienDien = 70000;
            $tienNuoc = 50000;
            $phiDichVu = 50000;
            $tongTien = $tienPhong + $tienDien + $tienNuoc + $phiDichVu;

            $hoaDonPaid = Hoadon::create([
                'hopdong_id' => $hopdong->id,
                'phong_id' => $hopdong->phong_id,
                'ma_hoa_don' => 'HD-' . strtoupper(Str::random(10)),
                'loai_hoadon' => Hoadon::LOAI_MONTHLY,
                'tien_phong' => $tienPhong,
                'tien_dien' => $tienDien,
                'tien_nuoc' => $tienNuoc,
                'phi_dich_vu' => $phiDichVu,
                'tong_tien' => $tongTien,
                'trang_thai' => InvoiceStatus::Paid,
                'ngay_het_han' => now()->subMonth()->endOfMonth()->toDateString(),
                'ngay_thanh_toan' => now()->subMonth()->endOfMonth()->toDateString(),
                'ghi_chu' => 'Kỳ ' . now()->subMonth()->format('m/Y'),
            ]);

            ThanhToan::create([
                'hoadon_id' => $hoaDonPaid->id,
                'nguoi_xac_nhan' => $adminUser->id,
                'phuong_thuc' => ThanhToan::METHOD_TRANSFER,
                'ma_giao_dich' => 'TX-' . strtoupper(Str::random(10)),
                'so_tien' => (int) $hoaDonPaid->tong_tien,
                'ngay_giao_dich' => now()->subMonth()->endOfMonth(),
                'ghi_chu' => null,
            ]);

            $hoaDonUnpaid = Hoadon::create([
                'hopdong_id' => $hopdong->id,
                'phong_id' => $hopdong->phong_id,
                'ma_hoa_don' => 'HD-' . strtoupper(Str::random(10)),
                'loai_hoadon' => Hoadon::LOAI_MONTHLY,
                'tien_phong' => $tienPhong,
                'tien_dien' => $tienDien,
                'tien_nuoc' => $tienNuoc,
                'phi_dich_vu' => $phiDichVu,
                'tong_tien' => $tongTien,
                'trang_thai' => InvoiceStatus::Unpaid,
                'ngay_het_han' => now()->endOfMonth()->toDateString(),
                'ngay_thanh_toan' => null,
                'ghi_chu' => 'Kỳ ' . now()->format('m/Y'),
            ]);

            if ((int) $hopdong->id === (int) ($hopdongs[0]->id ?? 0)) {
                ThanhToan::create([
                    'hoadon_id' => $hoaDonUnpaid->id,
                    'nguoi_xac_nhan' => null,
                    'phuong_thuc' => ThanhToan::METHOD_TRANSFER,
                    'ma_giao_dich' => 'TX-' . strtoupper(Str::random(10)),
                    'so_tien' => (int) $hoaDonUnpaid->tong_tien,
                    'ngay_giao_dich' => now(),
                    'ghi_chu' => 'Đã chuyển khoản, nhờ admin xác nhận.',
                ]);

                $hoaDonUnpaid->transitionTo(InvoiceStatus::PendingConfirmation->value);
                Lienhe::create([
                    'ho_ten' => $hopdong->sinhvien?->user?->name ?? 'Sinh viên',
                    'email' => $hopdong->sinhvien?->user?->email ?? 'sv@ktx.test',
                    'noi_dung' => 'Yêu cầu xác nhận thanh toán hóa đơn ' . $hoaDonUnpaid->ma_hoa_don . '.',
                    'trang_thai' => Lienhe::TRANG_THAI_CHUA_XU_LY,
                ]);
            }

            $phong = Phong::find($hopdong->phong_id);
            if ($phong) {
                $m = (int) now()->month;
                $y = (int) now()->year;
                ChiSoDienNuoc::updateOrCreate(
                    ['phong_id' => $phong->id, 'loai' => 'dien', 'thang' => $m, 'nam' => $y],
                    ['chi_so_cu' => 1000, 'chi_so_moi' => 1100]
                );
                ChiSoDienNuoc::updateOrCreate(
                    ['phong_id' => $phong->id, 'loai' => 'nuoc', 'thang' => $m, 'nam' => $y],
                    ['chi_so_cu' => 200, 'chi_so_moi' => 230]
                );
            }
        }

        if (! empty($hopdongs)) {
            $hopdong = $hopdongs[0];
            YeuCauGiaHan::create([
                'hopdong_id' => $hopdong->id,
                'sinhvien_id' => $hopdong->sinhvien_id,
                'ngay_ket_thuc_moi' => now()->addMonths(6)->toDateString(),
                'ly_do' => 'Muốn gia hạn để tiếp tục ở KTX.',
                'trang_thai' => ExtensionStatus::Pending,
                'ghi_chu_admin' => null,
            ]);

            Dangky::create([
                'user_id' => $hopdong->sinhvien?->user_id,
                'ho_ten' => $hopdong->sinhvien?->user?->name ?? 'Sinh viên',
                'email' => $hopdong->sinhvien?->user?->email ?? 'sv@ktx.test',
                'phone_encrypted' => encrypt($hopdong->sinhvien?->user?->phone ?? '0900000000'),
                'id_card_encrypted' => encrypt('012345678999'),
                'gender' => ($hopdong->sinhvien?->user?->gender?->value ?? Gender::Male->value),
                'dob' => now()->subYears(20)->toDateString(),
                'toa_nha_id' => $hopdong->phong?->toa_nha_id,
                'loai_phong_id' => $roomType->id,
                'phong_id' => $hopdong->phong_id,
                'lookup_token' => Str::random(32),
                'token_expires_at' => now()->addDays(30),
                'trang_thai' => RegistrationStatus::Pending,
                'ghi_chu' => Dangky::GHI_CHU_TRA_PHONG . '|Muốn trả phòng cuối kỳ.',
            ]);
        }

        $rooms6Beds = Phong::query()
            ->withCount('giuongs')
            ->having('giuongs_count', 6)
            ->get();

        foreach ($rooms6Beds as $phong) {
            Taisan::updateOrCreate(
                ['ma_tai_san' => 'TS-' . $phong->ten_phong . '-DH'],
                [
                    'phong_id' => $phong->id,
                    'ten_tai_san' => 'Điều hòa',
                    'so_luong' => 1,
                    'tinh_trang' => 'Tốt',
                ]
            );
        }

        $sampleRooms = Phong::query()->whereIn('ten_phong', ['A101', 'B101'])->get();
        foreach ($sampleRooms as $phong) {
            $taiSan = Taisan::create([
                'phong_id' => $phong->id,
                'ten_tai_san' => 'Quạt trần',
                'ma_tai_san' => 'TS-' . $phong->ten_phong . '-QT',
                'so_luong' => 2,
                'tinh_trang' => 'Tốt',
            ]);

            $vattu = Vattu::create([
                'phong_id' => $phong->id,
                'ten_vat_tu' => 'Bóng đèn LED',
                'so_luong' => 4,
                'tinh_trang' => 'Mới',
                'mo_ta' => 'Bóng đèn chiếu sáng trong phòng',
                'ngay_mua' => now()->subMonths(3)->toDateString(),
                'thoi_gian_bao_hanh' => '12 tháng',
            ]);

            Lichsubaotri::create([
                'vattu_id' => $vattu->id,
                'phong_id' => $phong->id,
                'ngay_bao_tri' => now()->subDays(10)->toDateString(),
                'noi_dung' => 'Kiểm tra và thay bóng đèn hỏng',
                'chi_phi' => 120000,
                'don_vi_thuc_hien' => 'Đội bảo trì KTX',
                'nguoi_thuc_hien' => 'Kỹ thuật viên',
                'trang_thai' => Lichsubaotri::STATUS_DONE,
            ]);

            $sinhvien = Sinhvien::query()
                ->whereHas('current_hopdong', fn ($q) => $q->where('phong_id', $phong->id))
                ->first();

            if ($sinhvien) {
                $giuong = $sinhvien->current_hopdong?->giuong;
                Baohong::create([
                    'sinhvien_id' => $sinhvien->id,
                    'phong_id' => $phong->id,
                    'giuong_id' => $giuong?->id,
                    'taisan_id' => $taiSan->id,
                    'mo_ta' => 'Quạt trần kêu to, cần kiểm tra.',
                    'hinh_anh_path' => null,
                    'trang_thai' => BaohongStatus::Pending,
                    'muc_do' => Baohong::SEVERITY_LOW,
                    'chi_phi_du_kien' => 0,
                    'nguoi_chiu_phi' => Baohong::PAYER_STUDENT,
                ]);

                Kyluat::create([
                    'sinhvien_id' => $sinhvien->id,
                    'tieu_de' => 'Vi phạm giờ giấc',
                    'noi_dung' => 'Về muộn sau 23h không có lý do chính đáng.',
                    'muc_do' => DisciplineLevel::Low,
                    'ngay_vi_pham' => now()->subDays(3)->toDateString(),
                    'hinh_thuc_xu_ly' => 'Nhắc nhở',
                ]);
            }
        }

        Thongbao::create([
            'tieu_de' => 'Thông báo chung',
            'noi_dung' => 'KTX nhắc nhở sinh viên giữ gìn vệ sinh chung và tuân thủ nội quy.',
            'loai_thong_bao' => Thongbao::TYPE_GENERAL,
            'doi_tuong_nhan' => Thongbao::TARGET_ALL,
        ]);

        Thongbao::create([
            'tieu_de' => 'Lịch bảo trì',
            'noi_dung' => 'KTX sẽ bảo trì hệ thống điện nước khu A vào cuối tuần này.',
            'loai_thong_bao' => Thongbao::TYPE_MAINTENANCE,
            'doi_tuong_nhan' => Thongbao::TARGET_STUDENT,
        ]);

        Lienhe::create([
            'ho_ten' => 'Nguyễn Minh',
            'email' => 'minh@example.com',
            'noi_dung' => 'Mình muốn hỏi về điều kiện đăng ký phòng cho sinh viên năm nhất.',
            'trang_thai' => Lienhe::TRANG_THAI_CHUA_XU_LY,
            'ghi_chu_admin' => null,
        ]);

        $tenHo = ['Nguyễn', 'Trần', 'Lê', 'Phạm', 'Hoàng', 'Huỳnh', 'Phan', 'Vũ', 'Võ', 'Đặng', 'Bùi', 'Đỗ', 'Hồ', 'Ngô', 'Dương', 'Lý'];
        $tenDem = ['Văn', 'Thị', 'Minh', 'Quang', 'Hoàng', 'Thu', 'Anh', 'Đức', 'Ngọc', 'Hữu', 'Tuấn', 'Khánh', 'Thanh', 'Gia', 'Bảo'];
        $tenNam = ['An', 'Bình', 'Cường', 'Dũng', 'Hải', 'Hưng', 'Khang', 'Kiên', 'Long', 'Nam', 'Phúc', 'Sơn', 'Tài', 'Thắng', 'Trung', 'Vinh'];
        $tenNu = ['Anh', 'Chi', 'Dung', 'Giang', 'Hà', 'Hạnh', 'Hương', 'Lan', 'Linh', 'Mai', 'Ngân', 'Nhung', 'Oanh', 'Phương', 'Thảo', 'Trang', 'Yến'];

        $currentYear = (int) now()->year;
        $currentMonth = (int) now()->month;

        for ($i = 1; $i <= 20; $i++) {
            $gender = random_int(0, 1) === 0 ? Gender::Male : Gender::Female;
            $ho = $tenHo[array_rand($tenHo)];
            $dem = $tenDem[array_rand($tenDem)];
            $ten = $gender === Gender::Male ? $tenNam[array_rand($tenNam)] : $tenNu[array_rand($tenNu)];
            $fullName = trim($ho . ' ' . $dem . ' ' . $ten);

            $email = 'sv_demo' . $i . '@ktx.test';
            $phone = '09' . str_pad((string) (70000000 + $i), 8, '0', STR_PAD_LEFT);

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $fullName,
                    'password' => Hash::make('12345678'),
                    'vaitro' => UserRole::Student,
                    'gender' => $gender,
                    'phone' => $phone,
                    'is_active' => true,
                ]
            );

            $sinhvien = Sinhvien::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'ma_sinh_vien' => 'SV' . str_pad((string) (2000 + $i), 4, '0', STR_PAD_LEFT),
                    'lop' => 'CNTT-' . str_pad((string) random_int(1, 6), 2, '0', STR_PAD_LEFT),
                ]
            );

            $giuong = Giuong::query()
                ->where('trang_thai', BedStatus::Available)
                ->whereHas('phong', fn ($q) => $q->where('gioi_tinh_han_che', $gender->value))
                ->orderBy('id')
                ->first();

            if (! $giuong) {
                continue;
            }

            $giuong->update(['trang_thai' => BedStatus::Occupied]);

            $ngayBatDau = now()->setDate($currentYear, 1, 1)->startOfMonth();
            $ngayKetThuc = (clone $ngayBatDau)->addMonths(12)->subDay();

            $hopdong = Hopdong::create([
                'sinhvien_id' => $sinhvien->id,
                'phong_id' => $giuong->phong_id,
                'giuong_id' => $giuong->id,
                'ngay_bat_dau' => $ngayBatDau->toDateString(),
                'ngay_ket_thuc' => $ngayKetThuc->toDateString(),
                'gia_thuc_te' => (int) ($roomType->gia_thang ?? 500000),
                'tien_coc' => 1000000,
                'trang_thai' => ContractStatus::Active,
                'ghi_chu' => null,
            ]);

            for ($m = 1; $m <= $currentMonth; $m++) {
                $thang = now()->setDate($currentYear, $m, 1)->startOfMonth();
                $hetHan = (clone $thang)->endOfMonth();

                $tienPhong = (int) ($hopdong->gia_thuc_te ?? 0);
                $tienDien = random_int(50000, 120000);
                $tienNuoc = random_int(30000, 90000);
                $phiDichVu = (int) (DB::table('cauhinh')->where('ten', 'phi_dich_vu')->value('giatri') ?? 50000);
                $tongTien = $tienPhong + $tienDien + $tienNuoc + $phiDichVu;

                $hoaDon = Hoadon::create([
                    'hopdong_id' => $hopdong->id,
                    'phong_id' => $hopdong->phong_id,
                    'ma_hoa_don' => 'HD-' . $currentYear . str_pad((string) $m, 2, '0', STR_PAD_LEFT) . '-' . strtoupper(Str::random(8)),
                    'loai_hoadon' => Hoadon::LOAI_MONTHLY,
                    'tien_phong' => $tienPhong,
                    'tien_dien' => $tienDien,
                    'tien_nuoc' => $tienNuoc,
                    'phi_dich_vu' => $phiDichVu,
                    'tong_tien' => $tongTien,
                    'trang_thai' => InvoiceStatus::Paid,
                    'ngay_het_han' => $hetHan->toDateString(),
                    'ngay_thanh_toan' => $hetHan->subDays(random_int(0, 5))->toDateString(),
                    'ghi_chu' => 'Kỳ ' . $thang->format('m/Y'),
                ]);

                ThanhToan::create([
                    'hoadon_id' => $hoaDon->id,
                    'nguoi_xac_nhan' => $adminUser->id,
                    'phuong_thuc' => ThanhToan::METHOD_TRANSFER,
                    'ma_giao_dich' => 'TX-' . strtoupper(Str::random(10)),
                    'so_tien' => (int) $hoaDon->tong_tien,
                    'ngay_giao_dich' => $hoaDon->ngay_thanh_toan ? $hoaDon->ngay_thanh_toan->endOfDay() : now(),
                    'ghi_chu' => null,
                ]);
            }
        }
    }
}
