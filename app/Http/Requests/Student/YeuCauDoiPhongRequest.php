<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class YeuCauDoiPhongRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'phong_moi_id' => \App\Rules\CommonRules::phongMoiId(),
            'lydo' => ['required', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'phong_moi_id.required' => 'Vui lòng chọn phòng mới.',
            'phong_moi_id.numeric' => 'Phòng không hợp lệ.',
            'phong_moi_id.exists' => 'Phòng không tồn tại.',
            'lydo.required' => 'Vui lòng nhập lý do đổi phòng.',
            'lydo.string' => 'Lý do phải là văn bản.',
            'lydo.max' => 'Lý do không được vượt quá 500 ký tự.',
        ];
    }
}

