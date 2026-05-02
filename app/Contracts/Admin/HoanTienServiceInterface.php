<?php

namespace App\Contracts\Admin;

use App\Models\Hopdong;

interface HoanTienServiceInterface
{
    /**
     * Xử lý hoàn tiền cọc và phạt khi thanh lý hợp đồng.
     *
     * @param Hopdong $hopdong Hợp đồng đang thanh lý
     * @param int $phiHuHai Số tiền phạt / hư hại thiết bị
     * @return array Kết quả xử lý
     */
    public function xuLyHoanTien(Hopdong $hopdong, int $phiHuHai = 0): array;
}
