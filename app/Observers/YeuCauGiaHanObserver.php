<?php

namespace App\Observers;

use App\Models\YeuCauGiaHan;
use App\Services\Core\KiemToanService;

class YeuCauGiaHanObserver
{
    protected KiemToanService $kiemToanService;

    public function __construct(KiemToanService $kiemToanService)
    {
        $this->kiemToanService = $kiemToanService;
    }

    public function created(YeuCauGiaHan $yeuCauGiaHan): void
    {
        $this->kiemToanService->ghiNhatKy(
            'create',
            'YeuCauGiaHan',
            $yeuCauGiaHan->id,
            null,
            $yeuCauGiaHan->toArray()
        );
    }

    public function updated(YeuCauGiaHan $yeuCauGiaHan): void
    {
        $this->kiemToanService->ghiNhatKy(
            'update',
            'YeuCauGiaHan',
            $yeuCauGiaHan->id,
            $yeuCauGiaHan->getOriginal(),
            $yeuCauGiaHan->toArray()
        );
    }

    public function deleted(YeuCauGiaHan $yeuCauGiaHan): void
    {
        $this->kiemToanService->ghiNhatKy(
            'delete',
            'YeuCauGiaHan',
            $yeuCauGiaHan->id,
            $yeuCauGiaHan->toArray(),
            null
        );
    }
}

