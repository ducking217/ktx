<?php

namespace App\Http\Requests\Admin;

use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CapNhatPhongRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'toa_nha_id' => ['required', 'exists:toa_nha,id'],
            'loai_phong_id' => ['required', 'exists:loai_phong,id'],
            'ten_phong' => ['required', 'string', 'max:255'],
            'tang' => ['required', 'integer', 'min:1'],
            'gioi_tinh_han_che' => ['required', new Enum(Gender::class)],
            'mo_ta' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'toa_nha_id.required' => 'Vui lòng chọn tòa nhà.',
            'loai_phong_id.required' => 'Vui lòng chọn loại phòng.',
            'ten_phong.required' => 'Tên phòng không được để trống.',
            'tang.required' => 'Tầng không được để trống.',
            'gioi_tinh_han_che.required' => 'Giới tính không được để trống.',
        ];
    }
}
