<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'current_password' => 'required|string|min:6|max:255',
            'password' => 'required|string|min:6|max:255|confirmed',
            'password_confirmation' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'current_password' => 'Текущий пароль',
            'password' => 'Пароль',
            'password_confirmation' => 'Подтвержденный пароль',
        ];
    }
}
