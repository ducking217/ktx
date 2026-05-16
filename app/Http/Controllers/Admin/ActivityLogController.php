<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NhatKy;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**

 * Khu vực: Admin / Nhật ký hoạt động
 
 * Vai trò: Render danh sách log và chuẩn bị dữ liệu filter phục vụ tra cứu.

 */

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        // Phân quyền: Cho phép nhóm Admin truy cập
        $user = auth()->user();
        if (!$user instanceof User || !$user->isAdminGroup()) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        $query = NhatKy::query()->with('user');

        // Filter theo model
        if ($request->filled('model')) {
            $query->where('ten_model', $request->model);
        }

        // Filter theo người thực hiện
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter theo hành động
        if ($request->filled('action')) {
            $query->where('hanh_dong', $request->action);
        }

        // Filter theo ngày
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $logs = $query->orderByDesc('created_at')->paginate(50)->withQueryString();

        // Lấy danh sách để fill vào filter dropdowns
        $filterData = Cache::remember('admin.activity-log:filters:v1', now()->addMinutes(10), function (): array {
            return [
                'models' => NhatKy::query()->distinct()->pluck('ten_model')->filter()->values(),
                'actions' => NhatKy::query()->distinct()->pluck('hanh_dong')->filter()->values(),
                'admins' => User::query()
                    ->whereIn('vaitro', [UserRole::Admin])
                    ->select(['id', 'name', 'vaitro'])
                    ->orderBy('name')
                    ->get(),
            ];
        });

        return view('admin.activity-log', [
            'logs' => $logs,
            'models' => $filterData['models'],
            'admins' => $filterData['admins'],
            'actions' => $filterData['actions'],
        ]);
    }
}
