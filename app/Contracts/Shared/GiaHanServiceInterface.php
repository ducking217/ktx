<?php

namespace App\Contracts\Shared;

use App\Models\YeuCauGiaHan;
use Illuminate\Http\Request;

interface GiaHanServiceInterface
{
    public function lietKeYeuCauSinhVien(): array;

    public function lietKeYeuCauAdmin(Request $request): array;

    /**
     * Lấy hợp đồng đang hiệu lực của sinh viên.
     */
    public function layHopdongHieuLuc(int $sinhvienId): ?\App\Models\Hopdong;

    /**
     * Gửi yêu cầu gia hạn.
     */
    public function guiYeuCau(int $hopdongId, string $ngayKetThucMoi, ?string $lyDo): array;

    public function duyetYeuCau(int $yeuCauId, ?string $ghiChuAdmin = null): array;

    public function tuChoiYeuCau(int $yeuCauId, ?string $ghiChuAdmin = null): array;
}

