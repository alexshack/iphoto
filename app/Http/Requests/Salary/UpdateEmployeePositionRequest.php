<?php

namespace App\Http\Requests\Salary;

use App\Contracts\PositionContract;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeePositionRequest extends FormRequest
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
            PositionContract::FIELD_NAME => 'required|string|max:255',
            PositionContract::FIELD_STATUS => 'required|numeric|in:1,2'
        ];
    }

    public function attributes()
    {
        return [
            PositionContract::FIELD_NAME => 'Название',
            PositionContract::FIELD_STATUS => 'Статус'
        ];
    }
}
