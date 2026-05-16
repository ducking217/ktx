<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Contracts\Student\KyluatServiceInterface;

/**

 * Khu vực: Admin / Kỷ luật
 
 * Vai trò: CRUD kỷ luật và điều phối dữ liệu danh sách/filter.

 */

class KyluatController extends Controller
{
    public function __construct(
        private readonly KyluatServiceInterface $kyluatService
    ) {}

    /**
     * Discipline history of current student.
     */
    public function lietKeKyLuatSinhVien()
    {
        $data = $this->kyluatService->listKyluatStudent();
        return view('student.kyluat.index', $data);
    }
}
