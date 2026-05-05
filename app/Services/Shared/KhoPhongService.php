<?php

namespace App\Services\Shared;

use App\Contracts\Shared\KhoPhongServiceInterface;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\Dangky;
use App\Enums\RegistrationStatus;
use Illuminate\Http\Request;

class KhoPhongService implements KhoPhongServiceInterface
{
    public function layBanDoKyTucXa(Request $request): array
    {
        $toaNhaId = $request->query('toa_nha_id');
        if (!$toaNhaId) {
            $toaNhaId = \App\Models\ToaNha::first()?->id;
        }
        $tang = (int) $request->query('tang', 1);

        $danhsachphong = Phong::with(['loaiphong', 'giuongs.current_hopdong.sinhvien.user'])
            ->where('toa_nha_id', $toaNhaId)
            ->where('tang', $tang)
            ->orderBy('ten_phong')
            ->get();

        $mapData = $danhsachphong->map(fn($phong) => [
            'phong' => $phong,
            'beds' => $phong->giuongs->map(fn($g) => [
                'id' => $g->id,
                'no' => $g->ma_giuong,
                'status' => strtoupper($g->trang_thai instanceof \BackedEnum ? $g->trang_thai->value : (string)$g->trang_thai),
                'student' => $g->trang_thai === \App\Enums\BedStatus::Occupied ? [
                    'name' => $g->current_hopdong?->sinhvien?->user?->name ?? 'N/A',
                    'mssv' => $g->current_hopdong?->sinhvien?->ma_sinh_vien ?? ''
                ] : null
            ])
        ]);

        return [
            'mapData' => $mapData,
            'toaNhaId' => $toaNhaId,
            'tang' => $tang,
            'allToa' => \App\Models\ToaNha::orderBy('ten_toa_nha')->get(),
            'allTang' => Phong::where('toa_nha_id', $toaNhaId)->select('tang')->distinct()->orderBy('tang')->pluck('tang'),
            'campusStats' => $this->layThongKeCoSo(),
            'toa' => \App\Models\ToaNha::find($toaNhaId)?->ten_toa_nha ?? 'N/A'
        ];
    }

    public function layThongKeCoSo(): array
    {
        $totalBeds = \App\Models\Giuong::count();
        $occupied  = \App\Models\Giuong::where('trang_thai', \App\Enums\BedStatus::Occupied)->count();
        $pending   = \App\Models\Giuong::where('trang_thai', \App\Enums\BedStatus::Pending)->count();
        $broken    = \App\Models\Giuong::where('trang_thai', \App\Enums\BedStatus::Broken)->count();

        return [
            'total'     => $totalBeds,
            'available' => max(0, $totalBeds - $occupied - $pending - $broken),
            'occupied'  => $occupied,
            'pending'   => $pending,
            'broken'    => $broken,
        ];
    }

    public function layTrangThaiGiuong(int $phongId): array
    {
        $giuongs = \App\Models\Giuong::where('phong_id', $phongId)
            ->with(['current_hopdong.sinhvien.user'])
            ->orderBy('ma_giuong')
            ->get();

        return $giuongs->map(fn($g) => [
            'id'      => $g->id,
            'ma'      => $g->ma_giuong,
            'status'  => $g->trang_thai instanceof \BackedEnum ? $g->trang_thai->value : (string)$g->trang_thai,
            'label'   => method_exists($g->trang_thai, 'label') ? $g->trang_thai->label() : (string)$g->trang_thai,
            'student' => $g->trang_thai === \App\Enums\BedStatus::Occupied ? [
                'name' => $g->current_hopdong?->sinhvien?->user?->name ?? 'N/A',
                'mssv' => $g->current_hopdong?->sinhvien?->ma_sinh_vien ?? '',
            ] : null,
        ])->toArray();
    }
}
