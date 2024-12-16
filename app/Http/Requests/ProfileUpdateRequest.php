<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $this->user()->id],
            'current_password' => ['required', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }
}