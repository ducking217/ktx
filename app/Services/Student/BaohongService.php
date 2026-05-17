<?php

namespace App\Services\Student;

use App\Contracts\Core\KiemToanServiceInterface;
use App\Contracts\Student\BaohongServiceInterface;
use App\Enums\BaohongStatus;
use App\Models\Baohong;
use App\Models\Sinhvien;
use App\Models\Taisan;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**

 * Khu vực: Student / Báo hỏng
 
 * Vai trò: Nghiệp vụ tạo/cập nhật báo hỏng theo tài sản phòng của sinh viên.

 */

class BaohongService implements BaohongServiceInterface
{
    use PhanHoiService;

    public function __construct(
        private readonly KiemToanServiceInterface $kiemToanService
    ) {}

    public function getStudentMaintenanceRequests(): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
        if (!$sinhvien) return ['danhsachbaohong' => collect(), 'sinhvien' => null];

        $hopdong = $sinhvien->current_hopdong;
        $phongId = (int) ($hopdong?->phong_id ?? 0);
        $taisanTrongPhong = $phongId > 0
            ? Taisan::where('phong_id', $phongId)->orderBy('ten_tai_san')->get()
            : collect();

        return [
            'sinhvien' => $sinhvien,
            'danhsachbaohong' => Baohong::where('sinhvien_id', $sinhvien->id)
                ->with(['phong', 'taisan'])
                ->orderByDesc('created_at')
                ->get(),
            'taisanTrongPhong' => $taisanTrongPhong,
        ];
    }

    public function storeMaintenance(array $data, ?object $file): array
    {
        try {
            return DB::transaction(function () use ($data, $file) {
                $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
                if (!$sinhvien) {
                    return $this->traVeLoi('Không tìm thấy thông tin sinh viên. Vui lòng liên hệ ban quản lý.');
                }

                $hopdong = $sinhvien->current_hopdong;
                if (!$hopdong) {
                    return $this->traVeLoi('Bạn chưa được xếp phòng hoặc hợp đồng không còn hiệu lực.');
                }

                if (!$hopdong->phong_id) {
                    return $this->traVeLoi('Không xác định được phòng. Vui lòng liên hệ ban quản lý.');
                }

                $phongId = (int) $hopdong->phong_id;
                $taisanId = isset($data['taisan_id']) ? (int) $data['taisan_id'] : null;
                if ($taisanId) {
                    $taisanHopLe = Taisan::where('id', $taisanId)->where('phong_id', $phongId)->exists();
                    if (!$taisanHopLe) {
                        return $this->traVeLoi('Tài sản không hợp lệ hoặc không thuộc phòng của bạn.');
                    }
                }

                $imagePath = $this->handleImageUpload($file);

                $payload = [
                    'sinhvien_id'   => $sinhvien->id,
                    'phong_id'      => $phongId,
                    'giuong_id'     => $hopdong->giuong_id ? (int) $hopdong->giuong_id : null,
                    'mo_ta'         => $data['mota'],
                    'hinh_anh_path' => $imagePath,
                    'trang_thai'    => BaohongStatus::Pending->value,
                    'muc_do'        => Baohong::SEVERITY_LOW,
                ];

                if (Schema::hasColumn('baohong', 'taisan_id')) {
                    $payload['taisan_id'] = $taisanId ?: null;
                }

                $baohong = Baohong::create($payload);

                return $this->traVeThanhCong(
                    'Gửi báo hỏng thành công. Ban quản lý sẽ xử lý sớn nhất.',
                    ['baohong' => $baohong]
                );
            });
        } catch (\Throwable $e) {
            Log::error('BaohongService::storeMaintenance thất bại', [
                'user_id' => Auth::id(),
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            return $this->traVeLoi('Đã có lỗi xảy ra khi gửi yêu cầu. Vui lòng thử lại sau.');
        }
    }

    public function updateStudentMaintenance(int $id, array $data, ?object $file): array
    {
        try {
            return DB::transaction(function () use ($id, $data, $file) {
                $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
                if (!$sinhvien) {
                    return $this->traVeLoi('Không tìm thấy thông tin sinh viên.');
                }

                $baohong = Baohong::where('id', $id)->where('sinhvien_id', $sinhvien->id)->first();
                if (!$baohong) {
                    return $this->traVeLoi('Không tìm thấy báo hỏng.');
                }

                $status = $baohong->trang_thai instanceof BaohongStatus ? $baohong->trang_thai->value : (string) $baohong->trang_thai;
                if (!in_array($status, [BaohongStatus::Pending->value, BaohongStatus::Processing->value], true)) {
                    return $this->traVeLoi('Không thể chỉnh sửa báo hỏng ở trạng thái hiện tại.');
                }

                $hopdong = $sinhvien->current_hopdong;
                if (!$hopdong || !$hopdong->phong_id) {
                    return $this->traVeLoi('Không xác định được phòng hiện tại.');
                }

                $phongId = (int) $hopdong->phong_id;
                $taisanId = isset($data['taisan_id']) ? (int) $data['taisan_id'] : null;
                if ($taisanId) {
                    $taisanHopLe = Taisan::where('id', $taisanId)->where('phong_id', $phongId)->exists();
                    if (!$taisanHopLe) {
                        return $this->traVeLoi('Tài sản không hợp lệ hoặc không thuộc phòng của bạn.');
                    }
                }

                $newImagePath = $file ? $this->handleImageUpload($file) : null;
                if ($newImagePath) {
                    $oldPath = (string) ($baohong->hinh_anh_path ?? '');
                    if ($oldPath !== '') {
                        $fullOldPath = public_path(ltrim($oldPath, '/'));
                        if (File::exists($fullOldPath)) {
                            File::delete($fullOldPath);
                        }
                    }
                }

                $payload = [
                    'mo_ta' => $data['mota'],
                ];

                if (Schema::hasColumn('baohong', 'taisan_id')) {
                    $payload['taisan_id'] = $taisanId ?: null;
                }

                if ($newImagePath) {
                    $payload['hinh_anh_path'] = $newImagePath;
                }

                $baohong->update($payload);

                return $this->traVeThanhCong('Cập nhật báo hỏng thành công.', ['baohong' => $baohong]);
            });
        } catch (\Throwable $e) {
            Log::error('BaohongService::updateStudentMaintenance thất bại', [
                'user_id' => Auth::id(),
                'baohong_id' => $id,
                'error' => $e->getMessage(),
            ]);
            return $this->traVeLoi('Đã có lỗi xảy ra khi cập nhật báo hỏng.');
        }
    }

    public function listMaintenanceRequestsAdmin(Request $request): array
    {
        $status = $request->query('status', '');
        $statusEnum = BaohongStatus::tryFrom($status);

        $requests = Baohong::with(['sinhvien.user', 'phong'])
            ->when($statusEnum, fn ($q) => $q->where('trang_thai', $statusEnum))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return [
            'danhsachbaohong' => $requests,
            'status' => $statusEnum?->value,
        ];
    }

    public function updateMaintenance(int $id, array $data): array
    {
        try {
            $baohong = Baohong::find($id);
            if (!$baohong) return ['success' => false, 'message' => 'Không tìm thấy báo hỏng.'];

            return DB::transaction(function () use ($baohong, $data) {
                $oldData = $baohong->toArray();
                $baohong->update([
                    'trang_thai' => $data['trang_thai'],
                ]);

                $this->auditLog('Cập nhật trạng thái báo hỏng', 'Baohong', $baohong->id, $oldData, $baohong->toArray());

                $this->notifyStudent($baohong);

                return ['success' => true, 'message' => 'Cập nhật thành công.'];
            });
        } catch (\Throwable $e) {
            Log::error('BaohongService.updateMaintenance failed', ['baohong_id' => $id, 'exception' => $e]);
            $message = config('app.debug') ? $e->getMessage() : 'Có lỗi xảy ra, vui lòng thử lại.';
            return ['success' => false, 'message' => $message];
        }
    }

    private function handleImageUpload(?object $file): ?string
    {
        if (!$file) return null;

        $dir = public_path('anhbaohong');
        File::ensureDirectoryExists($dir);

        // Use random filename instead of original to prevent issues with
        // non-ASCII characters (Vietnamese), spaces, and path traversal.
        $extension = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $fileName  = time() . '_' . Str::random(12) . '.' . $extension;

        $file->move($dir, $fileName);

        return 'anhbaohong/' . $fileName;
    }

    private function auditLog(string $action, string $model, int $id, array $old, array $new): void
    {
        $this->kiemToanService->ghiNhatKy($action, $model, $id, $old, $new);
    }

    private function notifyStudent(object $baohong): void
    {
        $sinhvien = Sinhvien::with('user')->find($baohong->sinhvien_id);
        if ($sinhvien?->user) {
            $trangThaiLabel = $baohong->trang_thai instanceof BaohongStatus ? $baohong->trang_thai->label() : (string) ($baohong->trang_thai ?? 'N/A');
            $sinhvien->user->notify(new \App\Notifications\TrangThaiBaohongNotification(
                $baohong, 
                $trangThaiLabel
            ));
        }
    }
}
