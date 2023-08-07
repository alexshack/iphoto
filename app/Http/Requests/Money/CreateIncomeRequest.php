<?php

namespace App\Http\Requests\Money;

use App\Contracts\Money\IncomeContract;
use Illuminate\Foundation\Http\FormRequest;

class CreateIncomeRequest extends FormRequest
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
        return IncomeContract::RULES;
    }

    public function attributes()
    {
        return IncomeContract::ATTRIBUTES;
    }
}
