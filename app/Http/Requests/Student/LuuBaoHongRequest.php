<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class LuuBaoHongRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mota'       => ['required', 'string', 'min:10', 'max:2000'],
            'noidung'    => ['nullable', 'string', 'max:2000'],
            'taisan_id'  => ['nullable', 'integer', 'exists:taisan,id'],
            'anhminhhoa' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'mota.required' => 'Mô tả lỗi không được để trống.',
            'mota.string'   => 'Mô tả phải là văn bản.',
            'mota.min'      => 'Mô tả lỗi phải có ít nhất 10 ký tự.',
            'mota.max'      => 'Mô tả lỗi không được vượt quá 2000 ký tự.',
            'anhminhhoa.image' => 'Tệp đính kèm phải là hình ảnh.',
            'anhminhhoa.mimes' => 'Ảnh chỉ chấp nhận định dạng jpg, jpeg, png, webp.',
            'anhminhhoa.max'   => 'Ảnh tối đa 4MB.',
        ];
    }
}

