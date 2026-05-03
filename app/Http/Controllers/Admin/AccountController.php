<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\AccountServiceInterface;
use App\Http\Requests\Admin\LuuAccountRequest;
use App\Http\Requests\Admin\CapNhatAccountRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct(
        private readonly AccountServiceInterface $accountService
    ) {}

    public function index(Request $request)
    {
        $data = $this->accountService->lietKe($request);
        return view('admin.accounts.index', $data);
    }

    public function taoMoi()
    {
        $this->authorize('accounts.manage');
        return view('admin.accounts.form');
    }

    public function luu(LuuAccountRequest $request)
    {
        $this->authorize('accounts.manage');
        $response = $this->accountService->luu($request->validated());

        if ($response['toast_loai'] === 'thanhcong') {
            return redirect()->route('admin.accounts.index')->with('success', $response['toast_noidung']);
        }

        return back()->withInput()->with('error', $response['toast_noidung']);
    }

    public function sua(int $id)
    {
        $this->authorize('accounts.manage');
        $user = User::findOrFail($id);
        return view('admin.accounts.form', compact('user'));
    }

    public function capNhat(CapNhatAccountRequest $request, int $id)
    {
        $this->authorize('accounts.manage');
        $response = $this->accountService->capNhat($id, $request->validated());

        if ($response['toast_loai'] === 'thanhcong') {
            return redirect()->route('admin.accounts.index')->with('success', $response['toast_noidung']);
        }

        return back()->withInput()->with('error', $response['toast_noidung']);
    }

    public function xoa(int $id)
    {
        $this->authorize('accounts.manage');
        $response = $this->accountService->xoa($id);

        if ($response['toast_loai'] === 'thanhcong') {
            return redirect()->route('admin.accounts.index')->with('success', $response['toast_noidung']);
        }

        return back()->with('error', $response['toast_noidung']);
    }

    public function khoiPhuc(int $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('admin.accounts.index')->with('success', 'Đã khôi phục tài khoản thành công.');
    }
}
