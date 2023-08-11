<?php

namespace App\Http\Requests\Money;

use App\Contracts\Money\ExpenseContract;
use Illuminate\Foundation\Http\FormRequest;

class CreateExpenseRequest extends FormRequest
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
        return ExpenseContract::RULES;
    }

    public function attributes() {
        return ExpenseContract::ATTRIBUTES;
    }
}
