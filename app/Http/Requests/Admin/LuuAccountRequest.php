<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LuuAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'vaitro' => ['required', Rule::in([
                UserRole::Admin->value,
                UserRole::AdminTruong->value,
                UserRole::AdminToaNha->value,
            ])],
            'is_active' => ['nullable', 'boolean'],
            'toa_nha_id' => ['nullable', 'exists:toa_nhas,id'],
        ];
    }
}
