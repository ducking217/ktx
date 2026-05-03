<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CapNhatToaNhaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'ten_toa_nha' => ['required', 'string', 'max:255', 'unique:toa_nhas,ten_toa_nha,' . $id],
            'ma_toa_nha' => ['required', 'string', 'max:10', 'unique:toa_nhas,ma_toa_nha,' . $id],
            'mo_ta' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'ten_toa_nha.required' => 'Tên tòa nhà không được để trống.',
            'ten_toa_nha.unique' => 'Tên tòa nhà đã tồn tại.',
            'ma_toa_nha.required' => 'Mã tòa nhà không được để trống.',
            'ma_toa_nha.unique' => 'Mã tòa nhà đã tồn tại.',
            'ma_toa_nha.max' => 'Mã tòa nhà tối đa 10 ký tự.',
        ];
    }
}
