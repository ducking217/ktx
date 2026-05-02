<?php

namespace App\Services\Admin;

use App\Contracts\Admin\HoadonServiceInterface;
use App\Enums\InvoiceStatus;
use App\Models\Cauhinh;
use App\Models\Hoadon;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Notifications\HoadonMoiNotification;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HoadonService implements HoadonServiceInterface
{
    use PhanHoiService;
    private const DEFAULT_ELECTRICITY_RATE = 3500;
    private const DEFAULT_WATER_RATE = 15000;

    public function layBangGia(): array
    {
        return [
            'dongiadien' => (int) $this->layGiaTuCauhinh('gia_dien', (string) self::DEFAULT_ELECTRICITY_RATE),
            'dongianuoc' => (int) $this->layGiaTuCauhinh('gia_nuoc', (string) self::DEFAULT_WATER_RATE),
            'phidichvu' => (int) $this->layGiaTuCauhinh('phi_dich_vu', '50000'),
        ];
    }

    public function lietKeHoaDonAdmin(Request $request): array
    {
        $danhsachphong = Phong::withCount('danhsachsinhvien')->get()->map(function($phong) {
            $lastInvoice = Hoadon::where('phong_id', $phong->id)
                ->where('loai_hoadon', Hoadon::LOAI_MONTHLY)
                ->orderByDesc('nam')
                ->orderByDesc('thang')
                ->first();
            
            $phong->chisodien_cuoi = $lastInvoice ? $lastInvoice->chisodienmoi : 0;
            $phong->chisonuoc_cuoi = $lastInvoice ? $lastInvoice->chisonuocmoi : 0;
            return $phong;
        });

        return [
            'danhsachhoadon' => Hoadon::with(['phong', 'sinhvien.taikhoan'])->orderByDesc('created_at')->paginate(20)->withQueryString(),
            'danhsachphong' => $danhsachphong,
            'dongiadien' => $this->layBangGia()['dongiadien'],
            'dongianuoc' => $this->layBangGia()['dongianuoc'],
            'thongke' => [
                'tong_no' => (int) Hoadon::where('trangthaithanhtoan', '!=', InvoiceStatus::Paid->value)->sum('tongtien'),
                'so_qua_han' => Hoadon::where('trangthaithanhtoan', InvoiceStatus::Overdue->value)->count(),
                'so_cho_duyet' => Hoadon::where('trangthaithanhtoan', InvoiceStatus::Pending->value)->count(),
                'da_thu_thang' => (int) Hoadon::where('trangthaithanhtoan', InvoiceStatus::Paid->value)
                    ->where('thang', now()->month)
                    ->where('nam', now()->year)
                    ->sum('tongtien'),
            ]
        ];
    }

    public function layHoaDonSinhVien(): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
        if (!$sinhvien || !$sinhvien->phong_id) return ['error' => 'Bạn chưa có phòng.'];

        $lichSu = Hoadon::where('phong_id', $sinhvien->phong_id)->orderByDesc('nam')->orderByDesc('thang')->paginate(12);
        
        return [
            'hoadon' => $lichSu,
            'thongKe' => $this->layThongKeTaiChinhSinhVien($sinhvien->phong_id)
        ];
    }

    public function layChiTietHoaDonSinhVien(int $id): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
        $hoadon = Hoadon::where('id', $id)->where('phong_id', $sinhvien?->phong_id)->with('phong')->first();
        if (!$hoadon) return ['error' => 'Không tìm thấy hóa đơn.'];

        $soNguoi = Sinhvien::where('phong_id', $sinhvien->phong_id)->count();
        return [
            'hoadon' => $hoadon,
            'soNguoiTrongPhong' => $soNguoi,
            'chiTietTien' => [
                'tien_phong' => round($hoadon->tienphong / max(1, $soNguoi)),
                'tien_dien' => round($hoadon->tiendien / max(1, $soNguoi)),
                'tien_nuoc' => round($hoadon->tiennuoc / max(1, $soNguoi)),
                'phi_dich_vu' => round($hoadon->phidichvu / max(1, $soNguoi)),
                'tong_tien' => round($hoadon->tongtien / max(1, $soNguoi)),
            ]
        ];
    }

    public function xacNhanThanhToan(int $id): array
    {
        $hoadon = Hoadon::find($id);
        if (!$hoadon) return $this->traVeLoi('Không tìm thấy hóa đơn.');
        if (!$hoadon->transitionTo(InvoiceStatus::Paid->value)) return $this->traVeLoi('Không thể xác nhận.');

        return $this->traVeThanhCong('Xác nhận thanh toán thành công.');
    }

    public function xacNhanViPham(int $id): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
        $hoadon = Hoadon::where('id', $id)->where('sinhvien_id', $sinhvien?->id)->first();
        if (!$hoadon) return $this->traVeLoi('Không tìm thấy hóa đơn.');
        if (!$hoadon->transitionTo(InvoiceStatus::Pending->value)) return $this->traVeLoi('Không thể xác nhận.');

        return $this->traVeThanhCong('Đã xác nhận lỗi. Hãy thanh toán hóa đơn này.');
    }

    public function xuLyHoaDon(array $data): array
    {
        $phong = Phong::find($data['phong_id']);
        if (!$phong) return $this->traVeLoi('Không tìm thấy phòng.');

        $existing = Hoadon::where([
            'phong_id' => $data['phong_id'],
            'thang' => $data['thang'],
            'nam' => $data['nam'],
            'loai_hoadon' => Hoadon::LOAI_MONTHLY,
        ])->first();

        if ($existing && $existing->trangthaithanhtoan === InvoiceStatus::Paid) {
            return $this->traVeLoi('Hóa đơn tháng này đã được thanh toán. Không thể ghi đè.');
        }

        $bangGia = $this->layBangGia();
        
        $tiendien = ($data['chisodienmoi'] - $data['chisodiencu']) * $bangGia['dongiadien'];
        $tiennuoc = ($data['chisonuocmoi'] - $data['chisonuoccu']) * $bangGia['dongianuoc'];
        $phidichvu = $bangGia['phidichvu'];
        $tongtien = $phong->giaphong + $tiendien + $tiennuoc + $phidichvu;

        $hoadon = Hoadon::updateOrCreate([
            'phong_id' => $data['phong_id'],
            'thang' => $data['thang'],
            'nam' => $data['nam'],
            'loai_hoadon' => Hoadon::LOAI_MONTHLY,
        ], [
            'chisodiencu' => $data['chisodiencu'],
            'chisodienmoi' => $data['chisodienmoi'],
            'chisonuoccu' => $data['chisonuoccu'],
            'chisonuocmoi' => $data['chisonuocmoi'],
            'tienphong' => $phong->giaphong,
            'tiendien' => $tiendien,
            'tiennuoc' => $tiennuoc,
            'phidichvu' => $phidichvu,
            'tongtien' => $tongtien,
            'ngayxuat' => now()->format('Y-m-d'),
            'trangthaithanhtoan' => InvoiceStatus::Pending->value,
        ]);

        $this->thongBaoPhong($phong->id, $hoadon);
        return $this->traVeThanhCong('Xử lý hóa đơn thành công.');
    }

    public function taoHoaDonTheChan(Sinhvien $sinhvien): Hoadon
    {
        $amount = (int) $this->layGiaTuCauhinh('phi_the_chan', '1000000');
        return Hoadon::create([
            'sinhvien_id' => $sinhvien->id, 'phong_id' => $sinhvien->phong_id,
            'thang' => now()->month, 'nam' => now()->year, 'tongtien' => $amount,
            'loai_hoadon' => Hoadon::LOAI_DEPOSIT, 'trangthaithanhtoan' => InvoiceStatus::Pending->value,
            'ngayxuat' => now()->format('Y-m-d'),
        ]);
    }

    public function taoHoaDonHangThang(Sinhvien $sinhvien, int $month, int $year, ?string $startDate = null): Hoadon
    {
        $finalPrice = $startDate ? $this->tinhTienPhongTheoNgay((int)$sinhvien->phong->giaphong, $startDate) : (int)$sinhvien->phong->giaphong;
        $phidichvu = (int) $this->layGiaTuCauhinh('phi_dich_vu', '50000');
        
        return Hoadon::create([
            'sinhvien_id' => $sinhvien->id, 'phong_id' => $sinhvien->phong_id,
            'thang' => $month, 'nam' => $year, 
            'tongtien' => $finalPrice + $phidichvu, 
            'tienphong' => $finalPrice,
            'phidichvu' => $phidichvu,
            'loai_hoadon' => Hoadon::LOAI_MONTHLY, 'trangthaithanhtoan' => InvoiceStatus::Pending->value,
            'ngayxuat' => now()->format('Y-m-d'),
        ]);
    }

    public function taoHoaDonPhat(Sinhvien $sinhvien, int $amount, string $reason): Hoadon
    {
        return Hoadon::create([
            'sinhvien_id' => $sinhvien->id, 'phong_id' => $sinhvien->phong_id,
            'thang' => now()->month, 'nam' => now()->year, 'tongtien' => $amount,
            'loai_hoadon' => Hoadon::LOAI_PENALTY, 'trangthaithanhtoan' => InvoiceStatus::PendingConfirmation->value,
            'ngayxuat' => now()->format('Y-m-d'),
            'ghichu' => $reason
        ]);
    }

    public function tinhTienPhongTheoNgay(int $baseRoomFee, string $startDate): int
    {
        $start = \Illuminate\Support\Carbon::parse($startDate);
        $daysInMonth = $start->daysInMonth;
        $remainingDays = $daysInMonth - $start->day + 1;
        return (int) round(($baseRoomFee / $daysInMonth) * $remainingDays);
    }

    public function xuLyHoaDonHangLoat(array $data): array
    {
        try {
            return DB::transaction(function () use ($data) {
                $thang = (int) $data['thang'];
                $nam = (int) $data['nam'];
                $count = 0;

                foreach ($data['hoa_don'] as $phongId => $chiSo) {
                    if (!isset($chiSo['chisodienmoi']) || !isset($chiSo['chisonuocmoi'])) continue;

                    $this->xuLyHoaDon([
                        'phong_id' => $phongId,
                        'thang' => $thang,
                        'nam' => $nam,
                        'chisodiencu' => (int) ($chiSo['chisodiencu'] ?? 0),
                        'chisodienmoi' => (int) $chiSo['chisodienmoi'],
                        'chisonuoccu' => (int) ($chiSo['chisonuoccu'] ?? 0),
                        'chisonuocmoi' => (int) $chiSo['chisonuocmoi'],
                    ]);
                    $count++;
                }

                return $this->traVeThanhCong("Đã xử lý thành công {$count} hóa đơn.");
            });
        } catch (\Throwable $e) {
            return $this->traVeLoi('Lỗi khi xử lý hàng loạt: ' . $e->getMessage());
        }
    }

    private function layThongKeTaiChinhSinhVien(int $phongId): array
    {
        $stats = Hoadon::where('phong_id', $phongId)->get();
        return [
            'tong_hoa_don' => $stats->count(),
            'da_thanh_toan' => $stats->where('trangthaithanhtoan', InvoiceStatus::Paid->value)->count(),
            'chua_thanh_toan' => $stats->where('trangthaithanhtoan', InvoiceStatus::Pending->value)->count(),
            'tong_tien_da_tra' => $stats->where('trangthaithanhtoan', InvoiceStatus::Paid->value)->sum('tongtien'),
        ];
    }

    private function thongBaoPhong(int $phongId, Hoadon $hoadon): void
    {
        $students = Sinhvien::where('phong_id', $phongId)->with('taikhoan')->get();
        foreach ($students as $s) {
            if ($s->taikhoan) $s->taikhoan->notify(new HoadonMoiNotification($hoadon));
        }
    }

    private function layGiaTuCauhinh(string $key, string $defaultValue): string
    {
        $c = Cauhinh::where('ten', $key)->first();
        return $c ? $c->giatri : $defaultValue;
    }
}
