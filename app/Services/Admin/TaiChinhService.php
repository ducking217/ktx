<?php

namespace App\Services\Admin;

use App\Contracts\Admin\TaiChinhServiceInterface;
use App\Enums\InvoiceStatus;
use App\Models\Hoadon;
use App\Models\Phong;
use App\Models\Thongbao;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;

class TaiChinhService implements TaiChinhServiceInterface
{
    use PhanHoiService;

    public function lietKeCongNo(Request $request): array
    {
        $tuKhoa = $request->query('q', '');

        $data = Hoadon::where('trang_thai', InvoiceStatus::Overdue->value)
            ->when($tuKhoa, function ($q) use ($tuKhoa) {
                $q->whereHas('hopdong.sinhvien', fn ($sq) => $sq->where('ma_sinh_vien', 'like', '%' . \App\Helpers\SecurityHelper::escapeLike($tuKhoa) . '%'));
            })
            ->with(['hopdong.sinhvien.user', 'phong'])
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return ['hoadons' => $data, 'tuKhoa' => $tuKhoa];
    }

    public function layBaoCaoNoDong(Request $request): array
    {
        $raw = $this->lietKeCongNo($request);
        $hoaDons = collect($raw['hoadons']->items());

        $grouped = $hoaDons->groupBy('phong_id')->map(function ($items, $phongId) {
            $sinhviens = $items->pluck('hopdong.sinhvien')->filter()->unique('id')->values();
            $phong = $items->first()->phong ?? null;

            return [
                'phong' => $phong,
                'sinhvien' => $sinhviens,
                'hoadon' => $items->values(),
                'tong_tien' => (int) $items->sum('tong_tien'),
            ];
        });

        $thongKe = [
            'tong_phong_no' => $grouped->count(),
            'tong_sinh_vien_no' => $grouped->pluck('sinhvien')->flatten(1)->unique('id')->count(),
            'so_hoa_don_qua_han' => $hoaDons->count(),
            'tong_tien_no' => (int) $hoaDons->sum('tong_tien'),
        ];

        return [
            'congnoTheoPhong' => $grouped,
            'thongke' => $thongKe,
            'ngayQuaHan' => 0,
        ];
    }

    public function nhacNo(int $invoiceId): array
    {
        try {
            $hoadon = Hoadon::with(['hopdong.sinhvien.user', 'phong'])->find($invoiceId);
            if (! $hoadon) {
                return $this->traVeLoi('Không tìm thấy hóa đơn.');
            }

            $tenPhong = $hoadon->phong?->ten_phong ?? $hoadon->hopdong?->giuong?->phong?->ten_phong;

            Thongbao::create([
                'tieu_de' => 'Nhắc nhở thanh toán công nợ',
                'noi_dung' => "Vui lòng thanh toán hóa đơn #{$hoadon->id}"
                    . ($tenPhong ? " (Phòng {$tenPhong})" : '')
                    . ' trị giá ' . number_format((int) $hoadon->tong_tien) . 'đ.',
                'loai_thong_bao' => 'finance',
                'doi_tuong_nhan' => 'sinhvien',
            ]);

            return $this->traVeThanhCong('Đã gửi thông báo nhắc nợ.');
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    public function nhacNoTheoPhong(int $phongId): array
    {
        $invoiceIds = Hoadon::query()
            ->where('phong_id', $phongId)
            ->where('trang_thai', InvoiceStatus::Overdue->value)
            ->pluck('id');

        if ($invoiceIds->isEmpty()) {
            return $this->traVeLoi('Không có hóa đơn quá hạn để gửi nhắc nợ.');
        }

        foreach ($invoiceIds as $invoiceId) {
            $this->nhacNo((int) $invoiceId);
        }

        return $this->traVeThanhCong('Da gui thong bao nhac no cho phong.');
    }
}
