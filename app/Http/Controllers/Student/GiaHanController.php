<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Contracts\Shared\GiaHanServiceInterface;
use App\Models\Hopdong;
use App\Models\Sinhvien;
use App\Enums\ContractStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiaHanController extends Controller
{
    public function __construct(
        private readonly GiaHanServiceInterface $giaHanService
    ) {}

    public function index()
    {
        return redirect()->route('student.hopdong.index', ['tab' => 'gia-han']);
    }

    public function create()
    {
        return redirect()->route('student.hopdong.index', ['tab' => 'gia-han']);
    }

    public function store(Request $request)
    {
        $dulieu = $request->validate([
            'hopdong_id' => ['required', 'integer'],
            'ngay_ket_thuc_moi' => ['required', 'date', 'after:today'],
            'ly_do' => ['nullable', 'string', 'max:2000'],
        ]);

        $result = $this->giaHanService->guiYeuCau(
            (int) $dulieu['hopdong_id'],
            (string) $dulieu['ngay_ket_thuc_moi'],
            $dulieu['ly_do'] ?? null
        );

        return redirect()->route('student.hopdong.index', ['tab' => 'gia-han'])->with([
            'toast_loai' => $result['toast_loai'],
            'toast_noidung' => $result['toast_noidung'],
        ]);
    }
}
