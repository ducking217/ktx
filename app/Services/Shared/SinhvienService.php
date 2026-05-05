<?php

namespace App\Services\Shared;

use App\Contracts\Core\KiemToanServiceInterface;
use App\Contracts\Shared\SinhvienServiceInterface;
use App\Enums\BedStatus;
use App\Enums\ContractStatus;
use App\Models\Giuong;
use App\Models\Hopdong;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SinhvienService implements SinhvienServiceInterface
{
    use PhanHoiService;

    public function __construct(
        private readonly KiemToanServiceInterface $kiemToanService
    ) {}

    public function listStudents(Request $request): array
    {
        $tuKhoa = $request->query('q', '');

        $students = Sinhvien::when(
            $tuKhoa,
            function ($q) use ($tuKhoa) {
                $search = '%' . \App\Helpers\SecurityHelper::escapeLike(trim($tuKhoa)) . '%';
                $q->where(function ($sq) use ($search) {
                    $sq->where('ma_sinh_vien', 'like', $search)
                       ->orWhere('lop', 'like', $search)
                       ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', $search)
                                                         ->orWhere('phone', 'like', $search));
                });
            }
        )
            ->with(['user', 'current_hopdong.giuong.phong.toanha'])
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return [
            'danhsachsinhvien' => $students,
            'tuKhoa'           => $tuKhoa,
        ];
    }

    public function getStudentProfile(int $id): array
    {
        $baseQuery = Sinhvien::with([
            'user',
            'current_hopdong.giuong.phong.toanha',
            'hopdongs.giuong.phong',
            'kyluats' => fn($q) => $q->orderByDesc('ngay_vi_pham'),
            'danhgias' => fn($q) => $q->orderByDesc('created_at'),
        ]);

        $sinhvien = $baseQuery->find($id);
        if (! $sinhvien) {
            $sinhvien = $baseQuery->where('user_id', $id)->first();
        }

        if (!$sinhvien) return $this->traVeLoi('Không tìm thấy sinh viên.');

        // Lấy hóa đơn của tất cả các hợp đồng (không chỉ hợp đồng hiện tại)
        $hopdongIds = $sinhvien->hopdongs->pluck('id');
        $hoadons = \App\Models\Hoadon::whereIn('hopdong_id', $hopdongIds)
            ->orderByDesc('created_at')
            ->get();

        return [
            'sinhvien' => $sinhvien,
            'hoadons'  => $hoadons,
        ];
    }

    public function updateStudent(int $id, array $data): array
    {
        $sinhvien = Sinhvien::with('user')->find($id);
        if (!$sinhvien) return $this->traVeLoi('Không tìm thấy sinh viên.');

        $user = $sinhvien->user;
        if (!$user) return $this->traVeLoi('Không tìm thấy tài khoản liên kết.');

        DB::transaction(function () use ($user, $sinhvien, $data) {
            // Cập nhật thông tin trên bảng users
            $user->update([
                'name'   => $data['name']    ?? $user->name,
                'gender' => $data['gender'] ?? $user->gender,
                'phone'  => $data['phone']  ?? $user->phone,
            ]);

            // Cập nhật thông tin riêng của Sinhvien
            $sinhvien->update([
                'ma_sinh_vien' => $data['ma_sinh_vien'] ?? $sinhvien->ma_sinh_vien,
                'lop'          => $data['lop']          ?? $sinhvien->lop,
            ]);
        });

        return $this->traVeThanhCong('Cập nhật sinh viên thành công.');
    }

    /**
     * Admin thủ công xếp giường cho sinh viên (tìm giường trống trong phòng).
     */
    public function assignRoom(int $sinhvienId, ?int $phongId): array
    {
        try {
            return DB::transaction(function () use ($sinhvienId, $phongId) {
                $sinhvien = Sinhvien::where('id', $sinhvienId)->lockForUpdate()->first();
                if (!$sinhvien) throw new \Exception('Không tìm thấy sinh viên.');

                // ── Trường hợp: Rời phòng (phongId = null) ──────────────────
                if ($phongId === null || $phongId === 0) {
                    $this->terminateActiveContracts($sinhvienId);
                    return $this->traVeThanhCong('Rời phòng thành công.');
                }

                // ── Trường hợp: Xếp vào phòng mới ──────────────────────────
                $phong = Phong::with('loaiphong')->where('id', $phongId)->lockForUpdate()->first();
                if (!$phong) throw new \Exception('Phòng không tồn tại.');

                // Kiểm tra đã có hợp đồng active chưa
                if (Hopdong::where('sinhvien_id', $sinhvien->id)
                    ->where('trang_thai', ContractStatus::Active->value)
                    ->exists()) {
                    throw new \Exception('Sinh viên đang có hợp đồng hoạt động. Hãy thanh lý trước.');
                }

                // Kiểm tra giới tính phòng
                $sinhvien->loadMissing('user');
                $gioitinhSV = $sinhvien->user?->gender?->value;
                if ($phong->gioi_tinh_han_che->value !== 'any' && $gioitinhSV !== $phong->gioi_tinh_han_che->value) {
                    throw new \Exception('Giới tính sinh viên không phù hợp với phòng này.');
                }

                // Tìm giường trống trong phòng
                $giuong = Giuong::where('phong_id', $phong->id)
                    ->where('trang_thai', BedStatus::Available)
                    ->lockForUpdate()
                    ->first();

                if (!$giuong) throw new \Exception('Phòng đã đầy, không còn giường trống.');

                $ngayVao    = now()->format('Y-m-d');
                $ngayHetHan = now()->addMonths(5)->format('Y-m-d');

                // Tạo hợp đồng gắn với giường cụ thể
                Hopdong::create([
                    'sinhvien_id'   => $sinhvien->id,
                    'giuong_id'     => $giuong->id,
                    'ngay_bat_dau'  => $ngayVao,
                    'ngay_ket_thuc' => $ngayHetHan,
                    'gia_thuc_te'   => $phong->loaiphong->gia_thang ?? 0,
                    'trang_thai'    => ContractStatus::Active->value,
                ]);

                // Cập nhật trạng thái giường
                $giuong->update(['trang_thai' => BedStatus::Occupied->value]);

                $this->kiemToanService->ghiNhatKy(
                    'assign_room', 'Sinhvien', $sinhvien->id,
                    [],
                    ['phong_id' => $phong->id, 'giuong_id' => $giuong->id]
                );

                return $this->traVeThanhCong("Xếp phòng thành công: {$phong->ten_phong} — Giường {$giuong->ma_giuong}.");
            });
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    public function removeFromRoom(int $id): array
    {
        try {
            return DB::transaction(function () use ($id) {
                $sinhvien = Sinhvien::where('id', $id)->lockForUpdate()->first();
                if (!$sinhvien) throw new \Exception('Không tìm thấy sinh viên.');

                $this->terminateActiveContracts($sinhvien->id);
                return $this->traVeThanhCong('Rời phòng thành công.');
            });
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    // ─── Private Helpers ──────────────────────────────────────────────────────

    private function terminateActiveContracts(int $sinhvienId): void
    {
        $activeContracts = Hopdong::where('sinhvien_id', $sinhvienId)
            ->where('trang_thai', ContractStatus::Active->value)
            ->with('giuong')
            ->get();

        foreach ($activeContracts as $contract) {
            $contract->update(['trang_thai' => ContractStatus::Terminated->value]);
            // Giải phóng giường
            $contract->giuong?->update(['trang_thai' => BedStatus::Available->value]);
        }
    }
}
