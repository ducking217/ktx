<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Shared\TaiSanPhongServiceInterface;
use App\Models\Phong;
use App\Models\Taisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**

 * Khu vực: Admin / Tài sản
 
 * Vai trò: CRUD/gắn tài sản theo phòng và thao tác hàng loạt.

 */

class TaiSanController extends Controller
{
    public function __construct(
        private readonly TaiSanPhongServiceInterface $taiSanPhongService
    ) {}

    public function luu(Request $request, int $id)
    {
        $this->authorize('phong.manage');
        $duLieu = $request->validate([
            'ten_tai_san' => ['required', 'string', 'max:100'],
            'so_luong' => ['required', 'integer', 'min:1'],
            'tinh_trang' => ['required', 'string', 'max:100'],
        ]);

        $result = $this->taiSanPhongService->store($duLieu, $id);

        return redirect()->back()->with([
            'toast_loai' => $result['success'] ? 'thanhcong' : 'loi',
            'toast_noidung' => $result['message'],
        ]);
    }

    public function luuHangLoat(Request $request, int $id)
    {
        $this->authorize('phong.manage');
        $items = $request->input('items', []);

        if (!is_array($items) || count($items) === 0) {
            return redirect()->back()->with(['toast_loai' => 'loi', 'toast_noidung' => 'Dữ liệu tài sản không hợp lệ.']);
        }

        $soThem = 0;
        foreach ($items as $item) {
            $tenTaiSan = trim((string)($item['ten_tai_san'] ?? ''));
            if ($tenTaiSan === '') {
                continue;
            }

            $soLuong = (int)($item['so_luong'] ?? 0);
            $tinhTrang = trim((string)($item['tinh_trang'] ?? ''));
            if ($soLuong < 1 || $tinhTrang === '') {
                return redirect()->back()->with(['toast_loai' => 'loi', 'toast_noidung' => 'Vui lòng nhập đầy đủ thông tin các dòng có dữ liệu.']);
            }

            $this->taiSanPhongService->store([
                'ten_tai_san' => $tenTaiSan,
                'so_luong' => $soLuong,
                'tinh_trang' => $tinhTrang,
            ], $id);
            $soThem++;
        }

        return redirect()->back()->with([
            'toast_loai' => $soThem > 0 ? 'thanhcong' : 'loi',
            'toast_noidung' => $soThem > 0 ? "Đã thêm $soThem tài sản." : 'Không có dòng tài sản hợp lệ để thêm.',
        ]);
    }

    public function capNhatHangLoat(Request $request, int $id)
    {
        $this->authorize('phong.manage');
        $items = $request->input('items', []);

        if (!is_array($items) || count($items) === 0) {
            return redirect()->back()->with(['toast_loai' => 'loi', 'toast_noidung' => 'Dữ liệu tài sản không hợp lệ.']);
        }

        $soCapNhat = 0;
        $soXoa = 0;
        foreach ($items as $taisanId => $item) {
            $taisanId = (int) $taisanId;
            if ($taisanId < 1) {
                continue;
            }

            if ((bool)($item['xoa'] ?? false) === true) {
                $result = $this->taiSanPhongService->destroy($id, $taisanId);
                if ($result['success']) {
                    $soXoa++;
                }
                continue;
            }

            $tenTaiSan = trim((string)($item['ten_tai_san'] ?? ''));
            $soLuong = (int)($item['so_luong'] ?? 0);
            $tinhTrang = trim((string)($item['tinh_trang'] ?? ''));
            if ($tenTaiSan === '' || $soLuong < 1 || $tinhTrang === '') {
                return redirect()->back()->with(['toast_loai' => 'loi', 'toast_noidung' => 'Vui lòng nhập đầy đủ thông tin (hoặc tick xóa).']);
            }

            $result = $this->taiSanPhongService->update([
                'ten_tai_san' => $tenTaiSan,
                'so_luong' => $soLuong,
                'tinh_trang' => $tinhTrang,
            ], $id, $taisanId);

            if ($result['success']) {
                $soCapNhat++;
            }
        }

        return redirect()->back()->with([
            'toast_loai' => 'thanhcong',
            'toast_noidung' => "Đã cập nhật $soCapNhat tài sản, đã xóa $soXoa tài sản.",
        ]);
    }

    public function ganHangLoat(Request $request)
    {
        $this->authorize('phong.manage');
        $duLieu = $request->validate([
            'pham_vi' => ['required', 'in:toa,phong'],
            'toa_nha_id' => ['nullable', 'integer'],
            'phong_id' => ['nullable', 'integer'],
            'ten_tai_san' => ['required', 'string', 'max:100'],
            'so_luong' => ['required', 'integer', 'min:1'],
            'tinh_trang' => ['required', 'string', 'max:100'],
            'cong_don' => ['nullable', 'boolean'],
        ]);

        $phamVi = $duLieu['pham_vi'];
        $toaNhaId = (int)($duLieu['toa_nha_id'] ?? 0);
        $phongId = (int)($duLieu['phong_id'] ?? 0);
        if ($phamVi === 'toa' && $toaNhaId < 1) {
            return redirect()->back()->with(['toast_loai' => 'loi', 'toast_noidung' => 'Vui lòng chọn tòa nhà.']);
        }
        if ($phamVi === 'phong' && $phongId < 1) {
            return redirect()->back()->with(['toast_loai' => 'loi', 'toast_noidung' => 'Vui lòng chọn phòng.']);
        }

        $congDon = (bool)($duLieu['cong_don'] ?? true);
        $tenTaiSan = trim($duLieu['ten_tai_san']);
        $soLuong = (int)$duLieu['so_luong'];
        $tinhTrang = trim($duLieu['tinh_trang']);

        $roomIds = $phamVi === 'toa'
            ? Phong::where('toa_nha_id', $toaNhaId)->pluck('id')
            : collect([$phongId]);

        if ($roomIds->isEmpty()) {
            return redirect()->back()->with(['toast_loai' => 'loi', 'toast_noidung' => 'Không tìm thấy phòng để gán tài sản.']);
        }

        $soPhongXuLy = 0;
        DB::transaction(function () use ($roomIds, $tenTaiSan, $soLuong, $tinhTrang, $congDon, &$soPhongXuLy) {
            foreach ($roomIds as $rid) {
                $rid = (int)$rid;
                $existing = Taisan::where('phong_id', $rid)->where('ten_tai_san', $tenTaiSan)->first();
                if ($existing) {
                    $existing->update([
                        'so_luong' => $congDon ? ($existing->so_luong + $soLuong) : $soLuong,
                        'tinh_trang' => $tinhTrang,
                    ]);
                } else {
                    Taisan::create([
                        'phong_id' => $rid,
                        'ten_tai_san' => $tenTaiSan,
                        'so_luong' => $soLuong,
                        'tinh_trang' => $tinhTrang,
                    ]);
                }
                $soPhongXuLy++;
            }
        });

        return redirect()->back()->with([
            'toast_loai' => 'thanhcong',
            'toast_noidung' => "Đã gán tài sản cho $soPhongXuLy phòng.",
        ]);
    }

    public function capNhat(Request $request, int $id, int $taisanId)
    {
        $this->authorize('phong.manage');
        $duLieu = $request->validate([
            'ten_tai_san' => ['required', 'string', 'max:100'],
            'so_luong' => ['required', 'integer', 'min:1'],
            'tinh_trang' => ['required', 'string', 'max:100'],
        ]);

        $result = $this->taiSanPhongService->update($duLieu, $id, $taisanId);

        return redirect()->back()->with([
            'toast_loai' => $result['success'] ? 'thanhcong' : 'loi',
            'toast_noidung' => $result['message'],
        ]);
    }

    public function xoa(int $id, int $taisanId)
    {
        $this->authorize('phong.manage');
        $result = $this->taiSanPhongService->destroy($id, $taisanId);

        return redirect()->back()->with([
            'toast_loai' => $result['success'] ? 'thanhcong' : 'loi',
            'toast_noidung' => $result['message'],
        ]);
    }
}
