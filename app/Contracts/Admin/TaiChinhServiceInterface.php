<?php

namespace App\Contracts\Admin;

use Illuminate\Http\Request;

interface TaiChinhServiceInterface
{
    /**
     * Gửi thông báo nhắc nợ theo một hóa đơn.
     */
    public function nhacNo(int $invoiceId): array;
}
