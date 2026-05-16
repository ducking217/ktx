<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Contracts\Core\TruyVanPhongServiceInterface;
use Illuminate\Http\Request;

/**

 * Khu vực: Admin / Phòng
 
 * Vai trò: Điều phối CRUD phòng, hiển thị danh sách/chi tiết và gọi service truy vấn phòng.

 */

class PhongController extends Controller
{
    public function __construct(
        private readonly TruyVanPhongServiceInterface $truyVanPhongService,
    ) {}

    /**
     * Danh sách phòng công khai cho khách 
     */
    public function index(Request $request)
    {
        $data = $this->truyVanPhongService->lietKePhongCongKhai($request);
        return view('landing.phong.danhsach', $data);
    }

    /**
     * Chi tiết tài sản phòng công khai.
     */
    public function assets(int $id)
    {
        $data = $this->truyVanPhongService->layChiTietPhong($id);
        return view('landing.phong.vattu', $data);
    }
}
