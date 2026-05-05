<?php

namespace App\Http\Requests\Student;

use App\Enums\Gender;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CapNhatHoSoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'gender' => ['nullable', Rule::in([Gender::Male->value, Gender::Female->value, Gender::Other->value])],
            'dob' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'max:500'],
            'id_card' => ['nullable', 'string', 'max:30'],
            'ma_sinh_vien' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('sinhvien', 'ma_sinh_vien')->ignore($this->user()->sinhvien->id ?? 0),
            ],
            'lop' => ['nullable', 'string', 'max:50'],
            'khoa' => ['nullable', 'string', 'max:100'],
            'ngay_nhap_hoc' => ['nullable', 'date'],
            'anh_the' => ['nullable', 'image', 'max:4096'],
            'anh_cccd' => ['nullable', 'image', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'ma_sinh_vien.unique' => 'Mã sinh viên này đã tồn tại trên hệ thống.',
        ];
    }
}
