<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\ToaNhaServiceInterface;
use App\Contracts\Shared\NghiepVuPhongServiceInterface;
use App\Enums\Gender;
use App\Models\LoaiPhong;
use App\Models\ToaNha;
use App\Http\Requests\Admin\LuuToaNhaRequest;
use App\Http\Requests\Admin\CapNhatToaNhaRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

/**

 * Khu vực: Admin / Tòa nhà
 
 * Vai trò: CRUD tòa nhà (danh mục cơ sở vật chất).

 */

class ToaNhaController extends Controller
{
    public function __construct(
        private readonly ToaNhaServiceInterface $toaNhaService,
        private readonly NghiepVuPhongServiceInterface $nghiepVuPhongService,
    ) {}

    public function index()
    {
        $danhSachToaNha = $this->toaNhaService->danhSach();
        return view('admin.toanha.index', compact('danhSachToaNha'));
    }

    public function taoMoi()
    {
        $this->authorize('toanha.manage');
        $loaiphongs = \App\Models\LoaiPhong::orderBy('ten_loai')->get();
        return view('admin.toanha.form', compact('loaiphongs'));
    }

    public function luu(LuuToaNhaRequest $request)
    {
        $this->authorize('toanha.manage');
        $validated = $request->validated();
        $gioiTinh = (string) ($validated['gioi_tinh_han_che'] ?? Gender::Any->value);
        $toaData = Arr::only($validated, ['ten_toa_nha', 'ma_toa_nha', 'dia_chi', 'mo_ta', 'so_tang', 'so_phong']);
        $toaData['gioi_tinh'] = $gioiTinh;
        $toaNha = $this->toaNhaService->luu($toaData);

        $soTang = (int) ($validated['so_tang'] ?? 0);
        $soPhong = (int) ($validated['so_phong'] ?? 0);
        $loaiPhongId = (int) ($validated['loai_phong_id'] ?? LoaiPhong::orderBy('id')->value('id') ?? 0);

        if ($soTang > 0 && $soPhong > 0) {
            if ($loaiPhongId <= 0) {
                return redirect()->route('admin.toanha.index')->with([
                    'toast_loai' => 'loi',
                    'toast_noidung' => 'Khởi tạo tòa nhà thành công nhưng chưa thể tạo phòng tự động vì chưa có Loại phòng.',
                ]);
            }

            $kq = $this->khoiTaoPhongTuDong($toaNha, $soTang, $soPhong, $loaiPhongId, $gioiTinh);
            $message = "Khởi tạo tòa nhà thành công.";
            if (($kq['created'] ?? 0) > 0) {
                $message .= " Đã tạo {$kq['created']} phòng tự động.";
            }
            if (($kq['failed'] ?? 0) > 0) {
                $message .= " {$kq['failed']} phòng tạo thất bại.";
            }

            return redirect()->route('admin.toanha.index')->with([
                'toast_loai' => ($kq['failed'] ?? 0) > 0 ? 'loi' : 'thanhcong',
                'toast_noidung' => $message,
            ]);
        }

        return redirect()->route('admin.toanha.index')->with([
            'toast_loai' => 'thanhcong',
            'toast_noidung' => 'Khởi tạo tòa nhà thành công.',
        ]);
    }

    public function chiTiet(int $id)
    {
        $toaNha = $this->toaNhaService->timKiem($id);
        $mauPhong = $toaNha->phongs()->orderBy('id')->first();
        $defaultGioiTinhHanChe = (string) (
            $toaNha->gioi_tinh?->value
            ?? $mauPhong?->gioi_tinh_han_che?->value
            ?? Gender::Any->value
        );

        return view('admin.toanha.form', compact('toaNha', 'defaultGioiTinhHanChe'));
    }

    public function capNhat(CapNhatToaNhaRequest $request, int $id)
    {
        $this->authorize('toanha.manage');
        $toaNha = $this->toaNhaService->timKiem($id);
        $validated = $request->validated();
        $toaData = Arr::only($validated, ['ten_toa_nha', 'ma_toa_nha', 'dia_chi', 'mo_ta', 'so_tang', 'so_phong']);
        if (isset($validated['gioi_tinh_han_che'])) {
            $toaData['gioi_tinh'] = (string) $validated['gioi_tinh_han_che'];
        }
        $this->toaNhaService->capNhat($toaNha, $toaData);

        $soTang = (int) ($validated['so_tang'] ?? 0);
        $soPhong = (int) ($validated['so_phong'] ?? 0);
        $phongHienTai = $toaNha->phongs()->count();

        if (isset($validated['gioi_tinh_han_che']) && $validated['gioi_tinh_han_che'] !== Gender::Any->value) {
            $toaNha->phongs()
                ->where('gioi_tinh_han_che', Gender::Any->value)
                ->update(['gioi_tinh_han_che' => (string) $validated['gioi_tinh_han_che']]);
        }

        $kq = ['created' => 0, 'failed' => 0];
        if ($soTang > 0 && $soPhong > 0 && $phongHienTai < $soPhong) {
            $mauPhong = $toaNha->phongs()->orderBy('id')->first();
            $loaiPhongId = (int) ($validated['loai_phong_id'] ?? $mauPhong?->loai_phong_id ?? LoaiPhong::orderBy('id')->value('id') ?? 0);
            $gioiTinh = (string) ($validated['gioi_tinh_han_che'] ?? $mauPhong?->gioi_tinh_han_che?->value ?? Gender::Any->value);
            $kq = $this->khoiTaoPhongTuDong($toaNha, $soTang, $soPhong, $loaiPhongId, $gioiTinh);
        }

        $message = 'Cập nhật tòa nhà thành công.';
        if (($kq['created'] ?? 0) > 0) {
            $message .= " Đã tạo thêm {$kq['created']} phòng theo quy mô mới.";
        }
        if (($kq['failed'] ?? 0) > 0) {
            $message .= " {$kq['failed']} phòng tạo thất bại.";
        }

        return redirect()->route('admin.toanha.index')->with([
            'toast_loai' => ($kq['failed'] ?? 0) > 0 ? 'loi' : 'thanhcong',
            'toast_noidung' => $message,
        ]);
    }

    public function xoa(int $id)
    {
        $this->authorize('toanha.manage');
        try {
            $toaNha = $this->toaNhaService->timKiem($id);
            $this->toaNhaService->xoa($toaNha);

            return redirect()->route('admin.toanha.index')->with([
                'toast_loai' => 'thanhcong',
                'toast_noidung' => 'Đã xóa tòa nhà khỏi hệ thống.',
            ]);
        } catch (Exception $e) {
            Log::error('ToaNhaController.xoa failed', ['toa_nha_id' => $id, 'exception' => $e]);
            $message = config('app.debug') ? $e->getMessage() : 'Không thể xóa tòa nhà. Vui lòng thử lại.';
            return redirect()->back()->with([
                'toast_loai' => 'loi',
                'toast_noidung' => $message,
            ]);
        }
    }

    private function khoiTaoPhongTuDong(ToaNha $toaNha, int $soTang, int $soPhong, int $loaiPhongId, string $gioiTinh): array
    {
        if ($loaiPhongId <= 0) {
            return ['created' => 0, 'failed' => 0];
        }

        $existing = $toaNha->phongs()->pluck('ten_phong')->map(fn ($v) => (string) $v)->all();
        $existingMap = array_fill_keys($existing, true);

        $roomsPerFloor = (int) ceil($soPhong / max(1, $soTang));
        $created = 0;
        $failed = 0;
        $total = count($existing);

        for ($tang = 1; $tang <= $soTang; $tang++) {
            for ($i = 1; $i <= $roomsPerFloor; $i++) {
                if ($total + $created >= $soPhong) {
                    break 2;
                }

                $tenPhong = strtoupper((string) $toaNha->ma_toa_nha) . $tang . str_pad((string) $i, 2, '0', STR_PAD_LEFT);
                if (isset($existingMap[$tenPhong])) {
                    continue;
                }

                $result = $this->nghiepVuPhongService->luuPhong([
                    'toa_nha_id' => $toaNha->id,
                    'loai_phong_id' => $loaiPhongId,
                    'ten_phong' => $tenPhong,
                    'tang' => $tang,
                    'gioi_tinh_han_che' => $gioiTinh,
                    'mo_ta' => null,
                ]);

                if (($result['success'] ?? false) === true) {
                    $created++;
                    $existingMap[$tenPhong] = true;
                } else {
                    $failed++;
                }
            }
        }

        return ['created' => $created, 'failed' => $failed];
    }
}
