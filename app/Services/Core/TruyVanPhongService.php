<?php

namespace App\Services\Core;

use App\Contracts\Core\TruyVanPhongServiceInterface;
use App\Enums\ContractStatus;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\Hopdong;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**

 * Khu vực: Core / Truy vấn phòng
 
 * Vai trò: Truy vấn danh sách/chi tiết phòng (Admin/Student/Public) và các số liệu phụ trợ (giường, sắp trống).

 */

class TruyVanPhongService implements TruyVanPhongServiceInterface
{
    use PhanHoiService;

    public function lietKePhongChoAdmin(Request $request): array
    {
        $tuKhoa = $request->query('q', '');
        $tangLoc = $request->query('tang', '');
        $toaNhaId = $request->query('toa_nha_id', '');
        $viewMode = $request->query('view', 'table');

        $danhsachphong = Phong::query()
            ->select(['id', 'toa_nha_id', 'loai_phong_id', 'ten_phong', 'tang', 'gioi_tinh_han_che', 'trang_thai'])
            ->with(['loaiphong', 'toanha'])
            ->withCount(['giuongs as so_nguoi_dang_o' => function ($query) {
                $query->where('trang_thai', \App\Enums\BedStatus::Occupied->value);
            }])
            ->when($tuKhoa, function ($query, $tuKhoa) {
                return $query->where('ten_phong', 'like', '%' . \App\Helpers\SecurityHelper::escapeLike(trim($tuKhoa)) . '%');
            })
            ->when($tangLoc, function ($query) use ($tangLoc) {
                return $query->where('tang', $tangLoc);
            })
            ->when($toaNhaId, function ($query) use ($toaNhaId) {
                return $query->where('toa_nha_id', $toaNhaId);
            })
            ->orderBy('tang')
            ->orderBy('ten_phong')
            ->paginate(20)
            ->withQueryString();

        $soluongdango_theophong = $danhsachphong->pluck('so_nguoi_dang_o', 'id')->toArray();
        $phongTheoTang = $danhsachphong->groupBy('tang');
        $danhsachtang = Cache::remember('admin.rooms:distinct-floors:v1', now()->addMinutes(10), function () {
            return Phong::query()
                ->select('tang')
                ->distinct()
                ->orderBy('tang')
                ->pluck('tang');
        });

        return compact('danhsachphong', 'phongTheoTang', 'soluongdango_theophong', 'tuKhoa', 'tangLoc', 'danhsachtang', 'viewMode');
    }

    public function lietKePhongCongKhai(Request $request): array
    {
        $tuKhoa = $request->query('q', '');
        $tangLoc = $request->query('tang', '');
        $gioiTinhLoc = $request->query('gioitinh', '');

        $danhsachphong = Phong::select('id', 'toa_nha_id', 'loai_phong_id', 'ten_phong', 'tang', 'gioi_tinh_han_che', 'trang_thai')
            ->with([
                'loaiphong',
                'toanha',
                'taisans:id,phong_id,ten_tai_san,so_luong',
                'vattus:id,phong_id,ten_vat_tu,so_luong',
            ])
            ->withCount(['giuongs as so_nguoi_dang_o' => function ($query) {
                $query->where('trang_thai', \App\Enums\BedStatus::Occupied);
            }])
            ->when($tuKhoa, function ($query, $tuKhoa) {
                return $query->where('ten_phong', 'like', '%' . \App\Helpers\SecurityHelper::escapeLike(trim($tuKhoa)) . '%');
            })
            ->when($tangLoc, function ($query) use ($tangLoc) {
                return $query->where('tang', $tangLoc);
            })
            ->when($gioiTinhLoc, function ($query) use ($gioiTinhLoc) {
                return $query->where('gioi_tinh_han_che', $gioiTinhLoc);
            })
            ->orderBy('tang')
            ->orderBy('ten_phong')
            ->get();

        $this->ganThongTinSapTrong($danhsachphong);

        $phongIds = $danhsachphong->pluck('id');
        $bedStatuses = $this->layTrangThaiGiuongHangLoat($phongIds);

        $soluongdango_theophong = $danhsachphong->pluck('so_nguoi_dang_o', 'id')->toArray();
        $phongTheoTang = $danhsachphong->groupBy('tang');
        $danhsachtang = Phong::select('tang')->distinct()->orderBy('tang')->pluck('tang');

        return compact('danhsachphong', 'phongTheoTang', 'soluongdango_theophong', 'tuKhoa', 'tangLoc', 'gioiTinhLoc', 'danhsachtang', 'bedStatuses');
    }

    public function lietKePhongChoSinhVien(Request $request): array
    {
        $tuKhoa = $request->query('q', '');
        $sinhvien = Sinhvien::where('user_id', auth()->id())->first();
        $gioitinhSinhvien = $sinhvien?->user?->gender;
        $gioitinhValue = $gioitinhSinhvien instanceof \App\Enums\Gender ? $gioitinhSinhvien->value : null;

        $danhsachphong = Phong::with([
                'loaiphong',
                'toanha',
                'taisans:id,phong_id,ten_tai_san,so_luong',
                'vattus:id,phong_id,ten_vat_tu,so_luong',
            ])
            ->withCount([
                'giuongs as so_giuong_da_o' => function ($query) {
                    $query->where('trang_thai', \App\Enums\BedStatus::Occupied);
                },
                'giuongs as so_giuong_trong' => function ($query) {
                    $query->where('trang_thai', \App\Enums\BedStatus::Available);
                },
                'taisans as so_tai_san_hong' => function ($query) {
                    $query->whereIn('tinh_trang', ['damaged', 'broken']);
                },
            ])
            ->when($tuKhoa, function ($query, $tuKhoa) {
                return $query->where('ten_phong', 'like', '%' . \App\Helpers\SecurityHelper::escapeLike(trim($tuKhoa)) . '%');
            })
            ->when($gioitinhValue, function ($query) use ($gioitinhValue) {
                return $query->where(function ($q) use ($gioitinhValue) {
                    $q->where('gioi_tinh_han_che', \App\Enums\Gender::Any->value)
                        ->orWhere('gioi_tinh_han_che', $gioitinhValue);
                });
            })
            ->whereHas('giuongs', function ($query) {
                $query->where('trang_thai', \App\Enums\BedStatus::Available);
            })
            ->orderBy('tang')
            ->orderBy('ten_phong')
            ->paginate(20)
            ->withQueryString();

        $soluongdango_theophong = $danhsachphong->pluck('so_giuong_da_o', 'id')->toArray();
        $danhsachphongtrong = $danhsachphong;

        return [
            'danhsachphongtrong' => $danhsachphongtrong,
            'danhsachphongsaptrong' => $this->lietKePhongSapTrong($gioitinhValue),
            'soluongdango_theophong' => $soluongdango_theophong,
            'tuKhoa' => $tuKhoa,
        ];
    }

    public function layChiTietPhong(int $id): array
    {
        $phong = Phong::with([
            'loaiphong',
            'toanha',
            'taisans',
            'vattus',
            'giuongs.current_hopdong.sinhvien.user',
        ])->find($id);
        if (!$phong) return ['error' => 'Không tìm thấy phòng.'];

        $beds = [];
        foreach ($phong->giuongs as $giuong) {
            $occupant = null;
            if ($giuong->trang_thai === \App\Enums\BedStatus::Occupied) {
                $hopdong = $giuong->current_hopdong;
                $occupant = [
                    'name' => $hopdong?->sinhvien?->user?->name ?? 'N/A',
                    'type' => 'student'
                ];
            }

            $beds[$giuong->id] = [
                'ma_giuong' => $giuong->ma_giuong,
                'status' => $giuong->trang_thai->value,
                'label' => $giuong->trang_thai->label(),
                'color' => $giuong->trang_thai->color(),
                'occupant' => $occupant
            ];
        }

        $soluongdango = $phong->giuongs->where('trang_thai', \App\Enums\BedStatus::Occupied)->count();
        $sochocontrong = $phong->giuongs->where('trang_thai', \App\Enums\BedStatus::Available)->count();

        return [
            'phong' => $phong,
            'sinhviens' => $phong->giuongs
                ->where('trang_thai', \App\Enums\BedStatus::Occupied)
                ->map(fn($g) => $g->current_hopdong?->sinhvien)
                ->filter()
                ->values(),
            'taisan' => $phong->taisans,
            'vattu' => $phong->vattus,
            'beds' => $beds,
            'soluongdango' => $soluongdango,
            'sochocontrong' => $sochocontrong,
        ];
    }

    private function layTrangThaiGiuongHangLoat(iterable $phongIds): array
    {
        $giuongs = \App\Models\Giuong::whereIn('phong_id', $phongIds)->get()->groupBy('phong_id');

        $statuses = [];
        foreach ($phongIds as $id) {
            $phongGiuongs = $giuongs->get($id, collect());
            $beds = [];
            foreach ($phongGiuongs as $giuong) {
                $beds[$giuong->id] = $giuong->trang_thai->value;
            }
            $statuses[$id] = $beds;
        }
        return $statuses;
    }

    private function ganThongTinSapTrong(\Illuminate\Support\Collection $danhsachphong, int $days = 30): void
    {
        $phongIds = $danhsachphong->pluck('id')->all();
        $sapTrongMap = $this->layThongTinSapTrongTheoPhongIds($phongIds, $days);

        foreach ($danhsachphong as $phong) {
            $info = $sapTrongMap[$phong->id] ?? null;
            $phong->setAttribute('so_giuong_sap_trong', (int) ($info['so_giuong_sap_trong'] ?? 0));
            $phong->setAttribute('ngay_trong_som_nhat', $info['ngay_trong_som_nhat'] ?? null);
        }
    }

    private function layThongTinSapTrongTheoPhongIds(array $phongIds, int $days = 30): array
    {
        if (count($phongIds) === 0) return [];

        $today = now()->toDateString();
        $until = now()->addDays($days)->toDateString();

        return Hopdong::query()
            ->selectRaw('phong_id, MIN(ngay_ket_thuc) as ngay_trong_som_nhat, COUNT(*) as so_giuong_sap_trong')
            ->whereIn('phong_id', $phongIds)
            ->where('trang_thai', ContractStatus::Active->value)
            ->whereBetween('ngay_ket_thuc', [$today, $until])
            ->groupBy('phong_id')
            ->get()
            ->mapWithKeys(function ($row) {
                return [
                    (int) $row->phong_id => [
                        'ngay_trong_som_nhat' => $row->ngay_trong_som_nhat ? Carbon::parse($row->ngay_trong_som_nhat) : null,
                        'so_giuong_sap_trong' => (int) ($row->so_giuong_sap_trong ?? 0),
                    ],
                ];
            })
            ->toArray();
    }

    private function lietKePhongSapTrong(?string $gioitinhValue, int $days = 30)
    {
        $today = now()->toDateString();
        $until = now()->addDays($days)->toDateString();

        $sapTrongRows = Hopdong::query()
            ->selectRaw('phong_id, MIN(ngay_ket_thuc) as ngay_trong_som_nhat, COUNT(*) as so_giuong_sap_trong')
            ->where('trang_thai', ContractStatus::Active->value)
            ->whereBetween('ngay_ket_thuc', [$today, $until])
            ->groupBy('phong_id')
            ->get();

        $phongIds = $sapTrongRows->pluck('phong_id')->map(fn($v) => (int) $v)->all();
        if (count($phongIds) === 0) return collect();

        $sapTrongMap = $sapTrongRows
            ->mapWithKeys(function ($row) {
                return [
                    (int) $row->phong_id => [
                        'ngay_trong_som_nhat' => $row->ngay_trong_som_nhat ? Carbon::parse($row->ngay_trong_som_nhat) : null,
                        'so_giuong_sap_trong' => (int) ($row->so_giuong_sap_trong ?? 0),
                    ],
                ];
            })
            ->toArray();

        $phongs = Phong::with([
                'loaiphong',
                'toanha',
                'taisans:id,phong_id,ten_tai_san,so_luong',
                'vattus:id,phong_id,ten_vat_tu,so_luong',
            ])
            ->withCount([
                'giuongs as so_giuong_trong' => function ($query) {
                    $query->where('trang_thai', \App\Enums\BedStatus::Available);
                },
            ])
            ->whereIn('id', $phongIds)
            ->when($gioitinhValue, function ($query) use ($gioitinhValue) {
                return $query->where(function ($q) use ($gioitinhValue) {
                    $q->where('gioi_tinh_han_che', \App\Enums\Gender::Any->value)
                        ->orWhere('gioi_tinh_han_che', $gioitinhValue);
                });
            })
            ->whereDoesntHave('giuongs', function ($query) {
                $query->where('trang_thai', \App\Enums\BedStatus::Available);
            })
            ->get()
            ->each(function ($phong) use ($sapTrongMap) {
                $info = $sapTrongMap[$phong->id] ?? null;
                $phong->setAttribute('so_giuong_sap_trong', (int) ($info['so_giuong_sap_trong'] ?? 0));
                $phong->setAttribute('ngay_trong_som_nhat', $info['ngay_trong_som_nhat'] ?? null);
            })
            ->sortBy('ngay_trong_som_nhat')
            ->values();

        return $phongs;
    }
}
