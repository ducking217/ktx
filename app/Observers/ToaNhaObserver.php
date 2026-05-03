<?php

namespace App\Observers;

use App\Models\ToaNha;
use App\Contracts\Core\KiemToanServiceInterface;

class ToaNhaObserver
{
    public function __construct(
        private readonly KiemToanServiceInterface $kiemToanService
    ) {}

    public function created(ToaNha $toaNha): void
    {
        $this->kiemToanService->ghiNhatKy(
            'create',
            'ToaNha',
            $toaNha->id,
            null,
            $toaNha->toArray()
        );
    }

    public function updated(ToaNha $toaNha): void
    {
        $this->kiemToanService->ghiNhatKy(
            'update',
            'ToaNha',
            $toaNha->id,
            $toaNha->getOriginal(),
            $toaNha->getChanges()
        );
    }

    public function deleted(ToaNha $toaNha): void
    {
        $this->kiemToanService->ghiNhatKy(
            'delete',
            'ToaNha',
            $toaNha->id,
            $toaNha->toArray(),
            null
        );
    }
}
