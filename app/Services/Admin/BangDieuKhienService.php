<?php

namespace App\Services\Admin;

use App\Contracts\Admin\BangDieuKhienServiceInterface;
use App\Enums\ContractStatus;
use App\Enums\InvoiceStatus;
use App\Enums\RegistrationStatus;
use App\Enums\BedStatus;
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
        $tongphongtrong = Phong::whereDoesntHave('giuongs', function ($query) {
            $query->where('trang_thai', '!=', \App\Enums\BedStatus::Available->value);
        })->count();
        $phongDangSuDung = $tongphong - $tongphongtrong;
        $tyLeLapDay = $tongphong > 0 ? (int)round(($phongDangSuDung / $tongphong) * 100) : 0;

        $doanhthuthang = (int)Hoadon::whereMonth('ngay_thanh_toan', $t)->whereYear('ngay_thanh_toan', $n)
            ->where('trang_thai', InvoiceStatus::Paid->value)
            ->sum('tong_tien');

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

        $yeuCauTraPhongChoDuyet = Dangky::where('trang_thai', RegistrationStatus::Pending->value)
            ->where('ghi_chu', 'like', 'TRA_PHONG%')
            ->count();

        $listTraPhong = Dangky::with(['user'])
            ->where('trang_thai', RegistrationStatus::Pending->value)
            ->where('ghi_chu', 'like', 'TRA_PHONG%')
            ->orderByDesc('id')
            ->limit(5)
            ->get()
            ->map(function ($dangky) {
                $name = $dangky->user?->name ?? $dangky->ho_ten ?? 'Sinh viên';

                return [
                    'id'      => $dangky->id,
                    'name'    => $name,
                    'initial' => substr($name, 0, 1),
                    'time'    => $dangky->created_at?->diffForHumans() ?? 'N/A',
                ];
            });

        return [
            'vaitro' => Auth::user()->vaitro ?? 'admin',
            'thanghientai' => $t,
            'namhientai' => $n,

            // Stats
            'tongphong' => $tongphong,
            'phongTrong' => $tongphongtrong,
            'phongDangSuDung' => $phongDangSuDung,
            'phongBaoTri' => Baohong::where('trang_thai', \App\Enums\BaohongStatus::Pending->value)->count(),
            'tyLeLapDay' => $tyLeLapDay,

            // Tài chính
            'doanhThuThangNay' => $doanhthuthang,
            'xuHuongDoanhThu' => $xuHuongDoanhThu,
            'maxDoanhThu' => $maxVal,
            'chenhLechDoanhThu' => $chenhLechDoanhThu,
            'tyLeDoanhThu' => $tyLeDoanhThu,

            // Hoạt động
            'dangKyChoDuyet' => Dangky::where('trang_thai', RegistrationStatus::Pending->value)->count(),
            'suCoMo' => Baohong::where('trang_thai', \App\Enums\BaohongStatus::Pending->value)->count(),
            'yeuCauTraPhongChoDuyet' => $yeuCauTraPhongChoDuyet,
            
            // Danh sách
            'listDangKy' => Dangky::with(['user', 'toanha', 'loaiphong'])
                ->where('trang_thai', RegistrationStatus::Pending->value)
                ->where(function ($query) {
                    $query->whereNull('ghi_chu')->orWhere('ghi_chu', 'not like', 'TRA_PHONG%');
                })
                ->orderByDesc('id')
                ->limit(5)
                ->get()
                ->map(function ($dangky) {
                    $trangThai = $dangky->trang_thai;
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

                    $name = $dangky->user?->name ?? $dangky->ho_ten ?? 'Sinh viên';
                    $phongName = $dangky->toanha?->ten_toa_nha . ' — ' . ($dangky->loaiphong?->ten_loai ?? 'N/A');
                    return [
                        'id'          => $dangky->id,
                        'name'        => $name,
                        'initial'     => substr($name, 0, 1),
                        'phongName'   => $phongName,
                        'time'        => $dangky->created_at?->diffForHumans() ?? 'N/A',
                        'statusLabel' => $statusLabel,
                        'statusClass' => $statusClass,
                    ];
                }),
            'listTraPhong' => $listTraPhong,
            'listBaoHong' => Baohong::with('phong')
                ->where('trang_thai', \App\Enums\BaohongStatus::Pending->value)
                ->orderByDesc('id')
                ->limit(5)
                ->get()
                ->map(function ($baohong) {
                    return [
                        'id'          => $baohong->id,
                        'mota'        => $baohong->mo_ta ?? 'Yêu cầu bảo trì',
                        'phongName'   => $baohong->phong?->ten_phong ?? 'N/A',
                        'time'        => $baohong->created_at?->format('H:i • d/m') ?? 'N/A',
                        'statusLabel' => $baohong->trang_thai?->label() ?? 'Đang chờ',
                    ];
                }),
            'listCongSuat' => $this->layCongSuatTheoToa(),
            
            // Các dữ liệu khác (nếu cần cho view cũ hoặc future use)
            'tongsinhvien' => Sinhvien::count(),
            'thongbao' => $this->layThongBaoChoAdmin(),
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
            'hopdongHienTai' => null,
            'soNgayCon' => null,
        ];

        if ($sinhvien) {
            $hopdongHienTai = Hopdong::where('sinhvien_id', $sinhvien->id)
                ->where('trang_thai', ContractStatus::Active->value)
                ->with(['giuong.phong.toanha', 'giuong.phong.loaiphong'])
                ->first();

            $data['hopdongHienTai'] = $hopdongHienTai;

            if ($hopdongHienTai) {
                $phong = $hopdongHienTai->giuong?->phong;
                $data['phonghientai']      = $phong;
                $data['soNgayCon']         = (int) now()->diffInDays($hopdongHienTai->ngay_ket_thuc, false);
                $data['taisanphong']       = $phong ? \App\Models\Taisan::where('phong_id', $phong->id)->get() : collect();
                $data['hoadonchuathanhtoan'] = \App\Models\Hoadon::where('hopdong_id', $hopdongHienTai->id)
                    ->where('trang_thai', InvoiceStatus::Unpaid->value)->get();
                
                // Bạn cùng giường/phòng
                if ($phong) {
                    $data['thanhviencungphong'] = Sinhvien::whereHas(
                        'hopdongs',
                        fn($q) => $q->where('trang_thai', ContractStatus::Active->value)
                            ->whereHas('giuong', fn($g) => $g->where('phong_id', $phong->id))
                    )->where('id', '<>', $sinhvien->id)->with('user')->get();
                }
            }

            $data['kyluatcuaem'] = \App\Models\Kyluat::where('sinhvien_id', $sinhvien->id)
                ->orderByDesc('ngay_vi_pham')->limit(5)->get();
        }

        return $data;
    }

    private function layThongBaoChoAdmin()
    {
        return Thongbao::whereIn('doi_tuong_nhan', ['all', 'admin'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();
    }

    private function layThongBaoChoSinhVien($sinhvien)
    {
        return Thongbao::whereIn('doi_tuong_nhan', ['all', 'sinhvien'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();
    }

    private function demPhongConTrong(): int
    {
        // Đếm phòng còn giường trống theo kiến trúc Bed-Centric mới
        return Phong::whereHas('giuongs', fn($q) =>
            $q->where('trang_thai', \App\Enums\BedStatus::Available->value)
        )->count();
    }

    private function layXuHuongDoanhThu(): array
    {
        $sauThangTruoc = now()->subMonths(5)->startOfMonth();
        
        $data = Hoadon::where('trang_thai', InvoiceStatus::Paid->value)
            ->where('ngay_thanh_toan', '>=', $sauThangTruoc)
            ->get();

        $tienphong = []; 
        $tiendichvu = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $m = now()->subMonths($i);
            $month = $m->month;
            $year = $m->year;

            $recordsInMonth = $data->filter(function($h) use ($month, $year) {
                return $h->ngay_thanh_toan->month == $month && $h->ngay_thanh_toan->year == $year;
            });

            $totalPhong = $recordsInMonth->sum('tien_phong');
            $totalDichVu = $recordsInMonth->sum(fn($h) => (int)$h->tien_dien + (int)$h->tien_nuoc + (int)$h->phi_dich_vu);

            $tienphong[] = $totalPhong;
            $tiendichvu[] = $totalDichVu;
        }

        return ['tienphong' => $tienphong, 'tiendichvu' => $tiendichvu];
    }

    private function layNhanDoanhThu(): array { $labels = []; for ($i = 5; $i >= 0; $i--) { $labels[] = now()->subMonths($i)->format('m/Y'); } return $labels; }

    private function layHopDongSapHetHan() {
        return Hopdong::where('trang_thai', ContractStatus::Active->value)
            ->whereDate('ngay_ket_thuc', '<=', now()->addDays(30))
            ->whereDate('ngay_ket_thuc', '>=', now())
            ->with(['sinhvien.user', 'giuong.phong'])
            ->orderBy('ngay_ket_thuc')
            ->limit(10)
            ->get();
    }

    private function layTieuThuBatThuong(int $t, int $n) {
        $sauThangTruoc = now()->subMonth();
        $thangTruoc = $sauThangTruoc->month;
        $namTruoc = $sauThangTruoc->year;

        $hoadons = Hoadon::with('hopdong.giuong')
            ->whereIn('loai_hoadon', ['dien_nuoc', 'monthly'])
            ->get();

        $hoadonThangTruoc = $hoadons->filter(function($h) use ($thangTruoc, $namTruoc) {
                $chiTiet = is_array($h->chi_tiet) ? $h->chi_tiet : json_decode($h->chi_tiet, true);
                return ($chiTiet['thang'] ?? 0) == $thangTruoc && ($chiTiet['nam'] ?? 0) == $namTruoc;
            })
            ->keyBy(fn($h) => $h->hopdong?->giuong?->phong_id);
            
        $hoadonThangNay = $hoadons->filter(function($h) use ($t, $n) {
            $chiTiet = is_array($h->chi_tiet) ? $h->chi_tiet : json_decode($h->chi_tiet, true);
            return ($chiTiet['thang'] ?? 0) == $t && ($chiTiet['nam'] ?? 0) == $n;
        });

        $abnormal = [];
        foreach ($hoadonThangNay as $h) {
            $phongId = $h->hopdong?->giuong?->phong_id;
            if (!$phongId) continue;

            if ($ht = $hoadonThangTruoc->get($phongId)) {
                $chiTietNay = is_array($h->chi_tiet) ? $h->chi_tiet : json_decode($h->chi_tiet, true);
                $chiTietTruoc = is_array($ht->chi_tiet) ? $ht->chi_tiet : json_decode($ht->chi_tiet, true);

                $dTn = (int)($chiTietNay['chisodienmoi'] ?? 0) - (int)($chiTietNay['chisodiencu'] ?? 0); 
                $dTt = (int)($chiTietTruoc['chisodienmoi'] ?? 0) - (int)($chiTietTruoc['chisodiencu'] ?? 0);
                
                if ($dTt > 0 && $dTn > $dTt * 1.5) {
                    $abnormal[] = [
                        'phong' => $h->hopdong?->giuong?->phong, 
                        'loai' => 'Điện', 
                        'thang_truoc' => $dTt, 
                        'thang_nay' => $dTn, 
                        'ty_le_tang' => round((($dTn - $dTt) / $dTt) * 100, 1)
                    ];
                }
            }
        }
        return collect($abnormal);
    }

    private function layCongSuatTheoToa() {
        // Theo kiến trúc mới: đếm giường trống/đã ở theo Tòa nhà
        $toanhis = \App\Models\ToaNha::with(['phongs.giuongs'])->get();
        $congSuat = [];
        foreach ($toanhis as $toa) {
            $allBeds    = $toa->phongs->flatMap(fn($p) => $p->giuongs);
            $total      = $allBeds->count();
            $occupied   = $allBeds->where('trang_thai', \App\Enums\BedStatus::Occupied)->count();
            $tyle       = $total > 0 ? (int)round(($occupied / $total) * 100) : 0;
            $congSuat[] = ['name' => $toa->ten_toa_nha, 'percentage' => $tyle];
        }
        return collect($congSuat)->sortBy('name')->values();
    }
}
