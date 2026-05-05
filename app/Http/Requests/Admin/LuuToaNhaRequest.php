<?php

namespace App\Http\Requests\Admin;

use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class LuuToaNhaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ten_toa_nha' => ['required', 'string', 'max:255', 'unique:toa_nha,ten_toa_nha'],
            'ma_toa_nha' => ['required', 'string', 'max:10', 'unique:toa_nha,ma_toa_nha'],
            'mo_ta' => ['nullable', 'string', 'max:500'],
            'so_tang' => ['nullable', 'integer', 'min:1', 'max:50'],
            'so_phong' => ['nullable', 'integer', 'min:1', 'max:2000'],
            'loai_phong_id' => ['nullable', 'exists:loai_phong,id'],
            'gioi_tinh_han_che' => ['nullable', new Enum(Gender::class)],
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
            'so_tang.integer' => 'Số tầng phải là số nguyên.',
            'so_tang.min' => 'Số tầng tối thiểu là 1.',
            'so_phong.integer' => 'Số phòng phải là số nguyên.',
            'so_phong.min' => 'Số phòng tối thiểu là 1.',
        ];
    }
}
