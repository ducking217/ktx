<?php

namespace App\Traits;

use App\Enums\ContractStatus;
use App\Models\Hopdong;
use App\Models\Phong;
use App\Models\Sinhvien;

trait HoTroNghiepVu
{
    /**
     * Chấm dứt tất cả hợp đồng hiện tại của sinh viên
     *
     * @param int $idSinhVien ID sinh viên
     * @return int Số lượng hợp đồng đã chấm dứt
     */
    protected function chamDutHopDongHienTai(int $idSinhVien): int
    {
        return Hopdong::where('sinhvien_id', $idSinhVien)
            ->where('trang_thai', ContractStatus::Active->value)
            ->update(['trang_thai' => ContractStatus::Terminated->value]);
    }
}
