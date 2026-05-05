<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Contracts\Student\BaohongServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BaohongController extends Controller
{
    public function __construct(
        private readonly BaohongServiceInterface $baohongService
    ) {}

    public function lietKeBaoHongSinhVien()
    {
        $data = $this->baohongService->getStudentMaintenanceRequests();
        return view('student.baohong.danhsach', $data);
    }

    public function luuBaoHong(\App\Http\Requests\Student\LuuBaoHongRequest $request)
    {
        Log::info('BaohongController::luuBaoHong called', [
            'user_id' => Auth::id(),
            'all_data' => $request->all(),
            'file' => $request->file('anhminhhoa'),
        ]);

        $dulieu = $request->validated();

        Log::info('Validated data', ['data' => $dulieu]);

        $result = $this->baohongService->storeMaintenance($dulieu, $request->file('anhminhhoa'));

        Log::info('Service result', ['result' => $result]);

        // BaohongService now returns PhanHoiService format: toast_loai / toast_noidung
        $isSuccess = ($result['toast_loai'] ?? '') === 'thanhcong';

        if ($request->wantsJson()) {
            return response()->json([
                'success' => $isSuccess,
                'message' => $result['toast_noidung'] ?? '',
                'data'    => $isSuccess ? ['id' => ($result['baohong']->id ?? null)] : null,
            ], $isSuccess ? 201 : 400);
        }

        return redirect()->back()->with([
            'toast_loai'   => $result['toast_loai']   ?? 'loi',
            'toast_noidung' => $result['toast_noidung'] ?? 'Đã có lỗi xảy ra.',
        ]);
    }
}
