<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\CapNhatHoSoRequest;
use App\Models\Hoadon;
use App\Models\Sinhvien;
use App\Enums\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $hoadons = collect();
        $hopdongHienTai = null;
        $phongHienTai = null;
        $giuongHienTai = null;
        
        if ($user->vaitro === UserRole::SinhVien) {
            $user->load([
                'sinhvien.dangkys',
                'sinhvien.hopdongs.giuong.phong.toanha',
                'sinhvien.current_hopdong.giuong.phong.toanha',
                'sinhvien.kyluats',
                'sinhvien.danhgias',
            ]);
            
            $hopdongHienTai = $user->sinhvien?->current_hopdong;
            $giuongHienTai = $hopdongHienTai?->giuong;
            $phongHienTai = $giuongHienTai?->phong;

            $hopdongIds = $user->sinhvien?->hopdongs?->pluck('id')->filter()->values() ?? collect();
            if ($hopdongIds->isNotEmpty()) {
                $hoadons = Hoadon::whereIn('hopdong_id', $hopdongIds->all())
                    ->orderByDesc('ngay_thanh_toan')
                    ->orderByDesc('created_at')
                    ->limit(50)
                    ->get();
            }
        }

        return view('profile.edit', [
            'user' => $user,
            'sinhvien' => $user->sinhvien,
            'hoadons' => $hoadons,
            'hopdongHienTai' => $hopdongHienTai,
            'phongHienTai' => $phongHienTai,
            'giuongHienTai' => $giuongHienTai,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(CapNhatHoSoRequest $request): RedirectResponse
    {
        $nguoiDung = $request->user();
        $validated = $request->validated();

        $nguoiDung->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'dob' => $validated['dob'] ?? null,
            'address' => $validated['address'] ?? null,
            'id_card' => $validated['id_card'] ?? null,
        ]);

        if ($nguoiDung->isDirty('email')) {
            $nguoiDung->email_verified_at = null;
        }

        $nguoiDung->save();

        if ($nguoiDung->vaitro === UserRole::SinhVien) {
            $sinhvien = $nguoiDung->sinhvien;
            if ($sinhvien) {
                $sinhvien->fill([
                    'lop' => $validated['lop'] ?? null,
                    'khoa' => $validated['khoa'] ?? null,
                    'ngay_nhap_hoc' => $validated['ngay_nhap_hoc'] ?? null,
                ]);
                $sinhvien->save();
            } elseif (!empty($validated['ma_sinh_vien'])) {
                $sinhvienMoi = new Sinhvien([
                    'user_id' => $nguoiDung->id,
                    'ma_sinh_vien' => $validated['ma_sinh_vien'],
                    'lop' => $validated['lop'] ?? null,
                    'khoa' => $validated['khoa'] ?? null,
                    'ngay_nhap_hoc' => $validated['ngay_nhap_hoc'] ?? null,
                ]);
                $sinhvienMoi->save();
                $sinhvien = $sinhvienMoi;
            }

            if ($sinhvien) {
                if ($request->hasFile('anh_the')) {
                    if ($sinhvien->anh_the_path) {
                        Storage::disk('private')->delete($sinhvien->anh_the_path);
                    }
                    $sinhvien->anh_the_path = $request->file('anh_the')->store("sinhvien/{$sinhvien->id}/anh-the", 'private');
                }
                if ($request->hasFile('anh_cccd')) {
                    if ($sinhvien->anh_cccd_path) {
                        Storage::disk('private')->delete($sinhvien->anh_cccd_path);
                    }
                    $sinhvien->anh_cccd_path = $request->file('anh_cccd')->store("sinhvien/{$sinhvien->id}/anh-cccd", 'private');
                }
                if ($sinhvien->isDirty(['anh_the_path', 'anh_cccd_path'])) {
                    $sinhvien->save();
                }
            }
        }

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated')
            ->with('toast_loai', 'thanhcong')
            ->with('toast_noidung', 'Cập nhật hồ sơ thành công.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $nguoiDung = $request->user();

        Auth::logout();

        $nguoiDung->forceDelete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
