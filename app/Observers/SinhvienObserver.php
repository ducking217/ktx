<?php

namespace App\Observers;

use App\Models\Phong;
use App\Models\Sinhvien;
use App\Services\Core\KiemToanService;

class SinhvienObserver
{
    protected KiemToanService $kiemToanService;

    public function __construct(KiemToanService $kiemToanService)
    {
        $this->kiemToanService = $kiemToanService;
    }

    /**
     * Handle the Sinhvien "created" event.
     */
    public function created(Sinhvien $sinhvien): void
    {
        $this->kiemToanService->ghiNhatKy(
            'create',
            'Sinhvien',
            $sinhvien->id,
            null,
            $sinhvien->toArray()
        );
    }

    /**
     * Handle the Sinhvien "updated" event.
     */
    public function updated(Sinhvien $sinhvien): void
    {
        // Ghi nhật ký các thay đổi
        $this->kiemToanService->ghiNhatKy(
            'update',
            'Sinhvien',
            $sinhvien->id,
            $sinhvien->getOriginal(),
            $sinhvien->toArray()
        );
    }

    /**
     * Handle the Sinhvien "deleted" event.
     */
    public function deleted(Sinhvien $sinhvien): void
    {
        $this->kiemToanService->ghiNhatKy(
            'delete',
            'Sinhvien',
            $sinhvien->id,
            $sinhvien->toArray(),
            null
        );
    }

    /**
     * Handle the Sinhvien "restored" event.
     */
    public function restored(Sinhvien $sinhvien): void
    {
        $this->kiemToanService->ghiNhatKy(
            'restore',
            'Sinhvien',
            $sinhvien->id,
            null,
            $sinhvien->toArray()
        );
    }
}
