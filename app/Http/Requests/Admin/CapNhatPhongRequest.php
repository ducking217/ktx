<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CapNhatPhongRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenphong' => ['required'],
            'tang' => ['required', 'numeric', 'min:1'],
            'giaphong' => ['required', 'numeric', 'min:0'],
            'succhuamax' => ['required', 'integer', 'min:1'],
            'mota' => ['nullable'],
            'gioitinh' => ['required', 'in:Nam,Nữ'],
        ];
    }

    public function messages(): array
    {
        return [
            'tenphong.required' => 'Tên phòng không được để trống.',
            'tang.required' => 'Tầng không được để trống.',
            'giaphong.required' => 'Giá phòng không được để trống.',
            'giaphong.numeric' => 'Giá phòng phải là số.',
            'succhuamax.required' => 'Sức chứa tối đa không được để trống.',
            'succhuamax.numeric' => 'Sức chứa tối đa phải là số.',
            'succhuamax.min' => 'Sức chứa tối đa phải lớn hơn hoặc bằng 1.',
            'gioitinh.required' => 'Giới tính không được để trống.',
        ];
    }
}


