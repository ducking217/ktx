<?php

namespace App\Services\Student;

use App\Contracts\Student\DanhgiaServiceInterface;
use App\Models\Danhgia;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Traits\PhanHoiService;
use Illuminate\Support\Facades\Auth;

class DanhgiaService implements DanhgiaServiceInterface
{
    use PhanHoiService;

    public function getRoomReviews(int $phongId): array
    {
        $phong = Phong::find($phongId);
        if (!$phong) return ['error' => 'Không tìm thấy phòng.'];

        $reviews = Danhgia::where('phong_id', $phongId)
            ->with('sinhvien.user')
            ->orderByDesc('created_at')
            ->paginate(10);

        return [
            'phong' => $phong,
            'danhsachdanhgia' => $reviews,
            'diemTrungBinh' => round(Danhgia::where('phong_id', $phongId)->avg('rating') ?? 0, 1),
        ];
    }

    public function storeReview(array $data): array
    {
        try {
            $sinhvien = Sinhvien::where('user_id', Auth::id())
                ->with('current_hopdong.giuong.phong')
                ->first();

            $hopdong = $sinhvien?->current_hopdong;
            $phong = $sinhvien?->phong_hien_tai()
                ?? ($hopdong?->phong_id ? Phong::find($hopdong->phong_id) : null);
            if (!$sinhvien || !$phong) {
                return $this->traVeLoi('Bạn chưa có phòng để đánh giá.');
            }

            if ($this->hasReviewedThisMonth($sinhvien, $phong->id)) {
                return $this->traVeLoi('Bạn đã đánh giá phòng trong tháng này rồi.');
            }

            Danhgia::create([
                'sinhvien_id' => $sinhvien->id,
                'phong_id' => $phong->id,
                'rating' => $data['diem'],
                'binh_luan' => $data['noidung'] ?? null,
            ]);

            return $this->traVeThanhCong('Cảm ơn bạn đã đánh giá phòng!');
        } catch (\Throwable $e) {
            return $this->traVeLoi('Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function getReviewFormContext(): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())
            ->with('current_hopdong.giuong.phong')
            ->first();

        $hopdong = $sinhvien?->current_hopdong;
        $phong = $sinhvien?->phong_hien_tai()
            ?? ($hopdong?->phong_id ? Phong::find($hopdong->phong_id) : null);
        if (!$sinhvien || !$phong) {
            return ['error' => 'Bạn chưa có phòng để đánh giá.'];
        }

        return [
            'phong' => $phong,
            'daDanhGia' => $this->hasReviewedThisMonth($sinhvien, $phong->id),
        ];
    }

    private function hasReviewedThisMonth(Sinhvien $sinhvien, int $phongId): bool
    {
        return Danhgia::where('sinhvien_id', $sinhvien->id)
            ->where('phong_id', $phongId)
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->exists();
    }
}
