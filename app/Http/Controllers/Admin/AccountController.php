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
        return view('admin.accounts.form');
    }

    public function luu(LuuAccountRequest $request)
    {
        $response = $this->accountService->luu($request->validated());

        if ($response['success']) {
            return redirect()->route('admin.accounts.index')->with('success', $response['message']);
        }

        return back()->withInput()->with('error', $response['message']);
    }

    public function sua(int $id)
    {
        $user = User::findOrFail($id);
        return view('admin.accounts.form', compact('user'));
    }

    public function capNhat(CapNhatAccountRequest $request, int $id)
    {
        $response = $this->accountService->capNhat($id, $request->validated());

        if ($response['success']) {
            return redirect()->route('admin.accounts.index')->with('success', $response['message']);
        }

        return back()->withInput()->with('error', $response['message']);
    }

    public function xoa(int $id)
    {
        $response = $this->accountService->xoa($id);

        if ($response['success']) {
            return redirect()->route('admin.accounts.index')->with('success', $response['message']);
        }

        return back()->with('error', $response['message']);
    }
}
