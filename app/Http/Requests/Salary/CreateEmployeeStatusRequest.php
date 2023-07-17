<?php

namespace App\Http\Requests\Salary;

use App\Contracts\Salary\EmployeeStatusContract;
use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeStatusRequest extends FormRequest
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
            EmployeeStatusContract::FIELD_NAME => 'required|string|max:255',
            EmployeeStatusContract::FIELD_STATUS => 'required|numeric|in:1,2'
        ];
    }

    public function attributes()
    {
        return [
            EmployeeStatusContract::FIELD_NAME => 'Название',
            EmployeeStatusContract::FIELD_STATUS => 'Статус'
        ];
    }
}
