<?php

declare(strict_types=1);

namespace App\Contracts\Admin;

use Illuminate\Http\Request;

interface BaoCaoServiceInterface
{
    /**
     * Lấy dữ liệu tổng hợp cho dashboard báo cáo tài chính.
     */
    public function layDuLieuTaiChinh(): array;

    /**
     * Lấy dữ liệu chi tiết để xuất Excel.
     */
    public function layDuLieuExport(array $filters): array;
}
