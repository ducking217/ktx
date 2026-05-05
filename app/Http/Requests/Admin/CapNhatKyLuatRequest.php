<?php

namespace App\Http\Requests\Admin;

use App\Enums\DisciplineLevel;
use Illuminate\Foundation\Http\FormRequest;

class CapNhatKyLuatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'noidung' => ['required', 'string'],
            'ngay_vi_pham' => ['required', 'date'],
            'muc_do' => ['required', 'string', 'in:' . implode(',', DisciplineLevel::values())],
        ];
    }
}


