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

    public function capNhatBaoHong(Request $request, int $id)
    {
        $dulieu = $request->validate([
            'mota'       => ['required', 'string', 'min:10', 'max:2000'],
            'taisan_id'  => ['nullable', 'integer', 'exists:taisan,id'],
            'anhminhhoa' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], [
            'mota.required' => 'Mô tả lỗi không được để trống.',
            'mota.min'      => 'Mô tả lỗi phải có ít nhất 10 ký tự.',
            'mota.max'      => 'Mô tả lỗi không được vượt quá 2000 ký tự.',
            'anhminhhoa.image' => 'Tệp đính kèm phải là hình ảnh.',
            'anhminhhoa.mimes' => 'Ảnh chỉ chấp nhận định dạng jpg, jpeg, png, webp.',
            'anhminhhoa.max'   => 'Ảnh tối đa 4MB.',
        ]);

        $result = $this->baohongService->updateStudentMaintenance($id, $dulieu, $request->file('anhminhhoa'));

        $isSuccess = ($result['toast_loai'] ?? '') === 'thanhcong';

        if ($request->wantsJson()) {
            return response()->json([
                'success' => $isSuccess,
                'message' => $result['toast_noidung'] ?? '',
            ], $isSuccess ? 200 : 400);
        }

        return redirect()->back()->with([
            'toast_loai'   => $result['toast_loai'] ?? 'loi',
            'toast_noidung' => $result['toast_noidung'] ?? 'Đã có lỗi xảy ra.',
        ]);
    }
}
