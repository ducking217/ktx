<?php

namespace App\Services\Shared;

use App\Contracts\Core\KiemToanServiceInterface;
use App\Contracts\Shared\SinhvienServiceInterface;
use App\Enums\ContractStatus;
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
        $students = Sinhvien::when($tuKhoa, fn($q) => $q->where('masinhvien', 'like', '%' . \App\Helpers\SecurityHelper::escapeLike(trim($tuKhoa)) . '%'))
            ->with(['taikhoan', 'phong'])
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return [
            'danhsachsinhvien' => $students,
            'danhsachphong' => Phong::all(),
            'tuKhoa' => $tuKhoa,
        ];
    }

    public function getStudentProfile(int $id): array
    {
        $sinhvien = Sinhvien::with([
            'taikhoan',
            'phong.toanha',
            'dangkys' => fn($q) => $q->orderByDesc('created_at'),
            'hopdongs' => fn($q) => $q->orderByDesc('ngay_bat_dau'),
            'kyluats' => fn($q) => $q->orderByDesc('ngayvipham'),
            'danhgias' => fn($q) => $q->orderByDesc('ngaydanhgia'),
        ])->find($id);

        if (!$sinhvien) return $this->traVeLoi('Không tìm thấy sinh viên.');

        // Lấy lịch sử hóa đơn của phòng mà sinh viên này đang ở
        $hoadons = collect();
        if ($sinhvien->phong_id) {
            $hoadons = \App\Models\Hoadon::where('phong_id', $sinhvien->phong_id)
                ->orderByDesc('nam')
                ->orderByDesc('thang')
                ->get();
        }

        return [
            'sinhvien' => $sinhvien,
            'hoadons' => $hoadons,
        ];
    }

    public function updateStudent(int $id, array $data): array
    {
        $sinhvien = Sinhvien::find($id);
        if (!$sinhvien) return $this->traVeLoi('Không tìm thấy sinh viên.');

        $taiKhoan = $sinhvien->taikhoan;
        if (!$taiKhoan) return $this->traVeLoi('Không tìm thấy tài khoản.');

        DB::transaction(function () use ($taiKhoan, $sinhvien, $data) {
            $taiKhoan->update(['name' => $data['name'], 'gioitinh' => $data['gioitinh']]);
            $sinhvien->update(['masinhvien' => $data['masinhvien'], 'lop' => $data['lop'], 'sodienthoai' => $data['sodienthoai']]);
        });

        return $this->traVeThanhCong('Cập nhật thành công.');
    }

    public function assignRoom(int $id, ?int $phongId): array
    {
        try {
            return DB::transaction(function () use ($id, $phongId) {
                $sinhvien = Sinhvien::where('id', $id)->with('taikhoan')->lockForUpdate()->first();
                if (!$sinhvien) throw new \Exception('Không tìm thấy sinh viên.');

                $oldPhongId = $sinhvien->phong_id;

                if ($phongId === null || $phongId === 0) {
                    $this->terminateActiveContracts($sinhvien->id);
                    $sinhvien->update(['phong_id' => null, 'ngay_vao' => null, 'ngay_het_han' => null]);
                    
                    if ($oldPhongId) {
                        $this->capNhatDango($oldPhongId);
                        $this->auditLog('Rời phòng', 'Sinhvien', $sinhvien->id, ['phong_id' => $oldPhongId], ['phong_id' => null]);
                    }
                    
                    return $this->traVeThanhCong('Rời phòng thành công.');
                }

                $phong = Phong::where('id', $phongId)->lockForUpdate()->first();
                if (!$phong) throw new \Exception('Phòng không tồn tại.');
                if ((int)$oldPhongId === (int)$phong->id) return $this->traVeThanhCong('Đang ở đúng phòng.');

                // [CONTRACT FLOW] Chấm dứt hợp đồng cũ
                $this->terminateActiveContracts($sinhvien->id);

                if (Sinhvien::where('phong_id', $phong->id)->count() >= (int)$phong->succhuamax) {
                    throw new \Exception('Phòng đã đủ người.');
                }

                if ($phong->gioitinh && $phong->gioitinh !== ($sinhvien->taikhoan->gioitinh->value ?? $sinhvien->taikhoan->gioitinh ?? null)) {
                    throw new \Exception('Giới tính không phù hợp.');
                }

                $ngayVao = now()->format('Y-m-d');
                $ngayHetHan = now()->addMonths(5)->format('Y-m-d');

                $sinhvien->update([
                    'phong_id' => $phong->id,
                    'ngay_vao' => $ngayVao,
                    'ngay_het_han' => $ngayHetHan
                ]);

                // [CONTRACT FLOW] Tạo hợp đồng mới tự động khi chuyển phòng
                Hopdong::create([
                    'sinhvien_id' => $sinhvien->id,
                    'phong_id' => $phong->id,
                    'ngay_bat_dau' => $ngayVao,
                    'ngay_ket_thuc' => $ngayHetHan,
                    'giaphong_luc_ky' => (int) $phong->giaphong,
                    'trang_thai' => ContractStatus::Active->value,
                ]);

                $this->capNhatDango($phong->id);
                if ($oldPhongId) $this->capNhatDango($oldPhongId);

                $this->auditLog('Chuyển phòng', 'Sinhvien', $sinhvien->id, ['phong_id' => $oldPhongId], ['phong_id' => $phong->id]);

                return $this->traVeThanhCong('Chuyển phòng và tạo hợp đồng mới thành công.');
            });
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    private function capNhatDango(int $phongId): void
    {
        $count = Sinhvien::where('phong_id', $phongId)->count();
        Phong::where('id', $phongId)->update(['dango' => $count]);
    }

    private function auditLog(string $action, string $model, int $id, array $old, array $new): void
    {
        $this->kiemToanService->ghiNhatKy($action, $model, $id, $old, $new);
    }

    public function removeFromRoom(int $id): array
    {
        try {
            return DB::transaction(function () use ($id) {
                $sinhvien = Sinhvien::where('id', $id)->lockForUpdate()->first();
                if (!$sinhvien) throw new \Exception('Không tìm thấy sinh viên.');

                $this->terminateActiveContracts($sinhvien->id);
                $sinhvien->update(['phong_id' => null, 'ngay_vao' => null, 'ngay_het_han' => null]);

                return $this->traVeThanhCong('Rời phòng thành công.');
            });
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    private function terminateActiveContracts(int $sinhvienId)
    {
        Hopdong::where('sinhvien_id', $sinhvienId)->where('trang_thai', ContractStatus::Active)->update(['trang_thai' => ContractStatus::Terminated]);
    }
}
