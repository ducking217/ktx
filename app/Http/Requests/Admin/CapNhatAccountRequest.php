<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CapNhatAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore((int)$id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'vaitro' => ['required', Rule::in([
                UserRole::Admin->value,
            ])],
            'is_active' => ['nullable', 'boolean'],
            'toa_nha_id' => ['nullable', 'exists:toa_nha,id'],
            'gender' => ['nullable', 'in:male,female,other'],
        ];
    }
}
