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
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**

 * Khu vực: Shared / Hồ sơ sinh viên
 
 * Vai trò: Truy vấn + cập nhật hồ sơ sinh viên (Admin/Student) và tập hợp dữ liệu liên quan.

 */

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
        ]);

        $sinhvien = $baseQuery->find($id);
        if (! $sinhvien) {
            $sinhvien = $baseQuery->where('user_id', $id)->first();
        }

        if (!$sinhvien) return $this->traVeLoi('Không tìm thấy sinh viên.');

        // Lấy hóa đơn của tất cả các hợp đồng (không chỉ hợp đồng hiện tại)
        $hopdongIds = $sinhvien->hopdongs->pluck('id');
        $hoadons = $hopdongIds->isEmpty()
            ? collect()
            : \App\Models\Hoadon::query()
                ->select(['id', 'hopdong_id', 'tong_tien', 'trang_thai', 'ngay_thanh_toan', 'created_at'])
                ->whereIn('hopdong_id', $hopdongIds)
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
            $user->fill([
                'name' => $data['name'] ?? $user->name,
                'email' => $data['email'] ?? $user->email,
                'phone' => $data['phone'] ?? null,
                'gender' => $data['gender'] ?? null,
                'dob' => $data['dob'] ?? null,
                'address' => $data['address'] ?? null,
                'id_card' => $data['id_card'] ?? null,
            ]);

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            $sinhvien->fill([
                'ma_sinh_vien' => $data['ma_sinh_vien'] ?? $sinhvien->ma_sinh_vien,
                'lop' => $data['lop'] ?? null,
                'khoa' => $data['khoa'] ?? null,
                'ngay_nhap_hoc' => $data['ngay_nhap_hoc'] ?? null,
            ]);

            $anhThe = $data['anh_the'] ?? null;
            if ($anhThe instanceof UploadedFile) {
                $sinhvien->anh_the_path = $this->replacePrivateFile(
                    $sinhvien->anh_the_path,
                    $anhThe,
                    "sinhvien/{$sinhvien->id}/anh-the"
                );
            }

            $anhCccd = $data['anh_cccd'] ?? null;
            if ($anhCccd instanceof UploadedFile) {
                $sinhvien->anh_cccd_path = $this->replacePrivateFile(
                    $sinhvien->anh_cccd_path,
                    $anhCccd,
                    "sinhvien/{$sinhvien->id}/anh-cccd"
                );
            }

            if ($sinhvien->isDirty()) {
                $sinhvien->save();
            }
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
                $sinhvien = $this->findSinhvienOrFailForUpdate($sinhvienId);

                if ($phongId === null || $phongId === 0) {
                    $this->terminateActiveContracts($sinhvienId);
                    return $this->traVeThanhCong('Rời phòng thành công.');
                }

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

                Hopdong::create([
                    'sinhvien_id'   => $sinhvien->id,
                    'phong_id'      => $phong->id,
                    'giuong_id'     => $giuong->id,
                    'ngay_bat_dau'  => $ngayVao,
                    'ngay_ket_thuc' => $ngayHetHan,
                    'gia_thuc_te'   => $phong->loaiphong->gia_thang ?? 0,
                    'trang_thai'    => ContractStatus::Active->value,
                ]);

                $giuong->update(['trang_thai' => BedStatus::Occupied->value]);

                $this->kiemToanService->ghiNhatKy(
                    'assign_room', 'Sinhvien', $sinhvien->id,
                    [],
                    ['phong_id' => $phong->id, 'giuong_id' => $giuong->id]
                );

                return $this->traVeThanhCong("Xếp phòng thành công: {$phong->ten_phong} — Giường {$giuong->ma_giuong}.");
            });
        } catch (\Throwable $e) {
            Log::error('SinhvienService.assignRoom failed', ['sinhvien_id' => $sinhvienId, 'phong_id' => $phongId, 'exception' => $e]);
            $message = config('app.debug') ? $e->getMessage() : 'Có lỗi xảy ra, vui lòng thử lại.';
            return $this->traVeLoi($message);
        }
    }

    public function removeFromRoom(int $id): array
    {
        try {
            return DB::transaction(function () use ($id) {
                $sinhvien = $this->findSinhvienOrFailForUpdate($id);

                $this->terminateActiveContracts($sinhvien->id);
                return $this->traVeThanhCong('Rời phòng thành công.');
            });
        } catch (\Throwable $e) {
            Log::error('SinhvienService.removeFromRoom failed', ['sinhvien_id' => $id, 'exception' => $e]);
            $message = config('app.debug') ? $e->getMessage() : 'Có lỗi xảy ra, vui lòng thử lại.';
            return $this->traVeLoi($message);
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
            $contract->giuong?->update(['trang_thai' => BedStatus::Available->value]);
        }
    }

    private function replacePrivateFile(?string $existingPath, UploadedFile $file, string $directory): string
    {
        if ($existingPath) {
            Storage::disk('private')->delete($existingPath);
        }

        return $file->store($directory, 'private');
    }

    private function findSinhvienOrFailForUpdate(int $sinhvienId): Sinhvien
    {
        $sinhvien = Sinhvien::where('id', $sinhvienId)->lockForUpdate()->first();
        if (! $sinhvien) {
            throw new \Exception('Không tìm thấy sinh viên.');
        }

        return $sinhvien;
    }
}
