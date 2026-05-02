<?php

namespace App\Services\Admin;

use App\Contracts\Admin\BangDieuKhienServiceInterface;
use App\Enums\ContractStatus;
use App\Enums\InvoiceStatus;
use App\Enums\RegistrationStatus;
use App\Models\Baohong;
use App\Models\Dangky;
use App\Models\Hoadon;
use App\Models\Hopdong;
use App\Models\Kyluat;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\Taisan;
use App\Models\Thongbao;
use Illuminate\Support\Facades\Auth;

class BangDieuKhienService implements BangDieuKhienServiceInterface
{
    public function layDuLieuBangDieuKhienAdmin(): array
    {
        $now = now();
        $t = (int)$now->month;
        $n = (int)$now->year;

        $tongphong = Phong::count();
        $tongphongtrong = $this->demPhongConTrong();
        $phongDangSuDung = $tongphong - $tongphongtrong;
        $tyLeLapDay = $tongphong > 0 ? (int)round(($phongDangSuDung / $tongphong) * 100) : 0;

        $doanhthuthang = (int)Hoadon::where('thang', $t)->where('nam', $n)
            ->where('trangthaithanhtoan', InvoiceStatus::Paid->value)
            ->sum('tongtien');

        $xuHuongDoanhThuRaw = $this->layXuHuongDoanhThu();
        $labels = $this->layNhanDoanhThu();

        $xuHuongDoanhThu = [];
        $maxVal = 1;
        foreach ($labels as $index => $label) {
            $val = (int)($xuHuongDoanhThuRaw['tienphong'][$index] ?? 0) + (int)($xuHuongDoanhThuRaw['tiendichvu'][$index] ?? 0);
            $xuHuongDoanhThu[] = ['label' => $label, 'value' => $val];
            if ($val > $maxVal) $maxVal = $val;
        }

        // Bổ sung phần trăm hiển thị cho biểu đồ
        foreach ($xuHuongDoanhThu as &$item) {
            $item['height'] = max(10, (int)round(($item['value'] / $maxVal) * 100));
            $item['percentage'] = (int)round(($item['value'] / $maxVal) * 100);
        }
        unset($item);

        // Tính tăng trưởng doanh thu so với tháng trước
        $doanhThuThangTruoc = 0;
        if (count($labels) >= 2) {
            $idx = count($labels) - 2;
            $doanhThuThangTruoc = (int)($xuHuongDoanhThuRaw['tienphong'][$idx] ?? 0) + (int)($xuHuongDoanhThuRaw['tiendichvu'][$idx] ?? 0);
        }
        $chenhLechDoanhThu = $doanhthuthang - $doanhThuThangTruoc;
        $tyLeDoanhThu = $doanhThuThangTruoc > 0 ? (int)round(($chenhLechDoanhThu / $doanhThuThangTruoc) * 100) : 100;

        return [
            'vaitro' => Auth::user()->vaitro ?? 'admin',
            'thanghientai' => $t,
            'namhientai' => $n,

            // Stats
            'tongphong' => $tongphong,
            'phongTrong' => $tongphongtrong,
            'phongDangSuDung' => $phongDangSuDung,
            'phongBaoTri' => Baohong::where('trangthai', \App\Enums\MaintenanceStatus::Pending->value)->count(),
            'tyLeLapDay' => $tyLeLapDay,

            // Tài chính
            'doanhThuThangNay' => $doanhthuthang,
            'xuHuongDoanhThu' => $xuHuongDoanhThu,
            'maxDoanhThu' => $maxVal,
            'chenhLechDoanhThu' => $chenhLechDoanhThu,
            'tyLeDoanhThu' => $tyLeDoanhThu,

            // Hoạt động
            'dangKyChoDuyet' => Dangky::where('trangthai', RegistrationStatus::Pending->value)->count(),
            'suCoMo' => Baohong::where('trangthai', \App\Enums\MaintenanceStatus::Pending->value)->count(),
            
            // Danh sách
            'listDangKy' => Dangky::with(['sinhvien.taikhoan', 'phong'])
                ->where('trangthai', RegistrationStatus::Pending->value)
                ->orderByDesc('id')
                ->limit(5)
                ->get()
                ->map(function ($dangky) {
                    $trangThai = $dangky->trangthai;
                    $statusLabel = 'Chờ duyệt';
                    $statusClass = 'bg-status-warning/10 text-status-warning ring-1 ring-status-warning/20';

                    if ($trangThai === RegistrationStatus::ApprovedPendingPayment) {
                        $statusLabel = 'Chờ tiền';
                        $statusClass = 'bg-blue-500/10 text-blue-600 ring-1 ring-blue-500/20';
                    } elseif ($trangThai === RegistrationStatus::Approved) {
                        $statusLabel = 'Đã duyệt';
                        $statusClass = 'bg-status-success/10 text-status-success ring-1 ring-status-success/20';
                    } elseif ($trangThai === RegistrationStatus::Rejected) {
                        $statusLabel = 'Từ chối';
                        $statusClass = 'bg-status-error/10 text-status-error ring-1 ring-status-error/20';
                    }

                    return [
                        'id' => $dangky->id,
                        'name' => $dangky->sinhvien?->taikhoan?->name ?? $dangky->ho_ten ?? 'Sinh viên',
                        'initial' => substr($dangky->sinhvien?->taikhoan?->name ?? $dangky->ho_ten ?? 'S', 0, 1),
                        'phongName' => $dangky->phong?->tenphong ?? 'Phòng chờ',
                        'time' => $dangky->created_at?->diffForHumans() ?? 'N/A',
                        'statusLabel' => $statusLabel,
                        'statusClass' => $statusClass,
                    ];
                }),
            'listBaoHong' => Baohong::with('phong')
                ->where('trangthai', \App\Enums\MaintenanceStatus::Pending->value)
                ->orderByDesc('id')
                ->limit(5)
                ->get()
                ->map(function ($baohong) {
                    return [
                        'id' => $baohong->id,
                        'mota' => $baohong->mota ?? 'Yêu cầu bảo trì',
                        'phongName' => $baohong->phong?->tenphong ?? 'N/A',
                        'time' => $baohong->created_at?->format('H:i • d/m') ?? 'N/A',
                        'statusLabel' => $baohong->trangthai?->label() ?? 'Đang chờ',
                    ];
                }),
            'listCongSuat' => $this->layCongSuatTheoToa(),
            
            // Các dữ liệu khác (nếu cần cho view cũ hoặc future use)
            'tongsinhvien' => Sinhvien::count(),
            'thongbao' => Thongbao::orderByDesc('ngaydang')->limit(5)->get(),
        ];
    }

    public function layDuLieuBangDieuKhienSinhVien(): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
        $t = (int)now()->month; $n = (int)now()->year;

        $data = [
            'vaitro' => Auth::user()->vaitro ?? 'sinhvien', 'thanghientai' => $t, 'namhientai' => $n,
            'sinhvien' => $sinhvien, 'phonghientai' => null, 'taisanphong' => collect(),
            'thanhviencungphong' => collect(), 'kyluatcuaem' => collect(),
            'hoadonchuathanhtoan' => collect(), 'hoadonChoXacNhan' => collect(),
            'lienhekhancap' => [['title' => 'Bảo vệ', 'phone' => '0900 111 222'], ['title' => 'Y tế', 'phone' => '0900 333 444']],
            'thongbao' => $this->layThongBaoChoSinhVien($sinhvien),
        ];

        if ($sinhvien && $sinhvien->phong_id) {
            $data['phonghientai'] = Phong::find($sinhvien->phong_id);
            $data['thanhviencungphong'] = Sinhvien::where('phong_id', $sinhvien->phong_id)->where('id', '<>', $sinhvien->id)->get();
            $data['kyluatcuaem'] = Kyluat::where('sinhvien_id', $sinhvien->id)->orderByDesc('ngayvipham')->limit(5)->get();
            $data['hoadonchuathanhtoan'] = Hoadon::where('phong_id', $sinhvien->phong_id)->where('trangthaithanhtoan', InvoiceStatus::Pending->value)->get();
            $data['hoadonChoXacNhan'] = Hoadon::where('sinhvien_id', $sinhvien->id)->where('trangthaithanhtoan', InvoiceStatus::PendingConfirmation->value)->get();
            $data['taisanphong'] = Taisan::where('phong_id', $sinhvien->phong_id)->get();
        }

        return $data;
    }

    private function layThongBaoChoSinhVien($sinhvien)
    {
        return Thongbao::where(function ($q) use ($sinhvien) {
            $q->where('doituong', 'sinhvien')->whereNull('phong_id')->whereNull('sinhvien_id');
            if ($sinhvien?->phong_id) $q->orWhere(fn($sq) => $sq->where('doituong', 'sinhvien')->where('phong_id', $sinhvien->phong_id));
            if ($sinhvien) $q->orWhere(fn($sq) => $sq->where('doituong', 'sinhvien')->where('sinhvien_id', $sinhvien->id));
        })->orderByDesc('ngaydang')->limit(5)->get();
    }

    private function demPhongConTrong(): int
    {
        return Phong::whereColumn('dango', '<', 'succhuamax')->count();
    }

    private function layXuHuongDoanhThu(): array
    {
        $sauThangTruoc = now()->subMonths(5)->startOfMonth();
        
        $data = Hoadon::selectRaw('thang, nam, SUM(tienphong) as total_phong, SUM(tiendien + tiennuoc) as total_dichvu')
            ->where('trangthaithanhtoan', InvoiceStatus::Paid->value)
            ->where(function($q) use ($sauThangTruoc) {
                $q->where('nam', '>', $sauThangTruoc->year)
                  ->orWhere(function($sq) use ($sauThangTruoc) {
                      $sq->where('nam', $sauThangTruoc->year)->where('thang', '>=', $sauThangTruoc->month);
                  });
            })
            ->groupBy('nam', 'thang')
            ->orderBy('nam')
            ->orderBy('thang')
            ->get()
            ->keyBy(fn($item) => sprintf('%02d/%d', $item->thang, $item->nam));

        $tienphong = []; 
        $tiendichvu = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $m = now()->subMonths($i);
            $key = $m->format('m/Y');
            $record = $data->get($key);
            
            $tienphong[] = (int)($record->total_phong ?? 0);
            $tiendichvu[] = (int)($record->total_dichvu ?? 0);
        }

        return ['tienphong' => $tienphong, 'tiendichvu' => $tiendichvu];
    }

    private function layNhanDoanhThu(): array { $labels = []; for ($i = 5; $i >= 0; $i--) { $labels[] = now()->subMonths($i)->format('m/Y'); } return $labels; }

    private function layHopDongSapHetHan() {
        return Hopdong::where('trang_thai', ContractStatus::Active->value)->whereDate('ngay_ket_thuc', '<=', now()->addDays(30))->whereDate('ngay_ket_thuc', '>=', now())
            ->with(['sinhvien.taikhoan', 'phong'])->orderBy('ngay_ket_thuc')->limit(10)->get();
    }

    private function layTieuThuBatThuong(int $t, int $n) {
        $hoadonThangTruoc = Hoadon::where('thang', now()->subMonth()->month)->where('nam', now()->subMonth()->year)->get()->keyBy('phong_id');
        $hoadonThangNay = Hoadon::where('thang', $t)->where('nam', $n)->with('phong')->get();
        $abnormal = [];
        foreach ($hoadonThangNay as $h) {
            if ($ht = $hoadonThangTruoc->get($h->phong_id)) {
                $dTn = $h->chisodienmoi - $h->chisodiencu; $dTt = $ht->chisodienmoi - $ht->chisodiencu;
                if ($dTt > 0 && $dTn > $dTt * 1.5) $abnormal[] = ['phong' => $h->phong, 'loai' => 'Điện', 'thang_truoc' => $dTt, 'thang_nay' => $dTn, 'ty_le_tang' => round((($dTn - $dTt) / $dTt) * 100, 1)];
            }
        }
        return collect($abnormal);
    }

    private function layCongSuatTheoToa() {
        $phongs = Phong::all()->groupBy('toa');
        $congSuat = [];
        foreach($phongs as $toa => $danhSach) {
            $dangO = $danhSach->sum('dango');
            $sucChua = $danhSach->sum('succhuamax');
            $tyle = $sucChua > 0 ? (int)round(($dangO / $sucChua) * 100) : 0;
            $tenToa = str_starts_with($toa ?? '', 'Tòa') ? $toa : 'Tòa ' . $toa;
            $congSuat[] = [
                'name' => $tenToa,
                'percentage' => $tyle
            ];
        }
        return collect($congSuat)->sortBy('name')->values();
    }
}
