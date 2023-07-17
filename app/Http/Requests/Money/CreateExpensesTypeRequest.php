<?php

namespace App\Http\Requests\Money;

use App\Contracts\Money\ExpensesTypeContract;
use Illuminate\Foundation\Http\FormRequest;

class CreateExpensesTypeRequest extends FormRequest
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
            ExpensesTypeContract::FIELD_NAME => 'required|string|max:255',
            ExpensesTypeContract::FIELD_STATUS => 'required|numeric|in:1,2'
        ];
    }

    public function attributes()
    {
        return [
            ExpensesTypeContract::FIELD_NAME => 'Название',
            ExpensesTypeContract::FIELD_STATUS => 'Статус'
        ];
    }
}
