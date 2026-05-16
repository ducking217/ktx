<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\BangDieuKhienServiceInterface;

/**

 * Khu vực: Admin / Dashboard
 
 * Vai trò: Render bảng điều khiển Admin từ dữ liệu tổng hợp.

 */

class TrangchuController extends Controller
{
    public function __construct(
        private readonly BangDieuKhienServiceInterface $bangDieuKhienService
    ) {}

    public function index()
    {
        $data = $this->bangDieuKhienService->layDuLieuBangDieuKhienAdmin();
        return view('admin.trangchu', $data);
    }
}
