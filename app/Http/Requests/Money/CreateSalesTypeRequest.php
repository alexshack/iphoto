<?php

namespace App\Http\Requests\Money;

use App\Contracts\Money\SalesTypeContract;
use Illuminate\Foundation\Http\FormRequest;

class CreateSalesTypeRequest extends FormRequest
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
            SalesTypeContract::FIELD_NAME => 'required|string|max:255',
            SalesTypeContract::FIELD_RECIPIENT => 'required|numeric|in:1,2,3',
            SalesTypeContract::FIELD_VALUE => 'required|numeric|max:100',
            SalesTypeContract::FIELD_STATUS => 'required|numeric|in:1,2'
        ];
    }

    public function attributes()
    {
        return [
            SalesTypeContract::FIELD_NAME => 'Название',
            SalesTypeContract::FIELD_RECIPIENT => 'Получатель',
            SalesTypeContract::FIELD_VALUE => 'Дополнительные расходы',
            SalesTypeContract::FIELD_STATUS => 'Статус'
        ];
    }
}
