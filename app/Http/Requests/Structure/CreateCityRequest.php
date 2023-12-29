<?php

namespace App\Http\Requests\Structure;

use App\Contracts\Structure\CityContract;
use Illuminate\Foundation\Http\FormRequest;

class CreateCityRequest extends FormRequest
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
            CityContract::FIELD_NAME => 'required|string|max:255',
            CityContract::FIELD_OPENING_DATE => 'required|date'
        ];
    }

    public function attributes()
    {
        return [
            CityContract::FIELD_NAME => 'Название города',
            CityContract::FIELD_OPENING_DATE => 'Дата открытия'
        ];
    }
}
