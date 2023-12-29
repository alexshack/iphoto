<?php

namespace App\Http\Requests\Structure;

use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\CityManagerContract;
use App\Contracts\UserContract;
use Illuminate\Foundation\Http\FormRequest;

class CreateCityManagerRequest extends FormRequest
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
            CityManagerContract::FIELD_CITY_ID => 'required|exists:' . CityContract::TABLE . ',' . CityContract::FIELD_ID,
            CityManagerContract::FIELD_MANAGER_ID => 'required|exists:' . UserContract::TABLE . ',' . UserContract::FIELD_ID,
            CityManagerContract::FIELD_APPOINTMENT_DATE => 'required|date'
        ];
    }

    public function attributes()
    {
        return [
            CityManagerContract::FIELD_CITY_ID => 'Город',
            CityManagerContract::FIELD_MANAGER_ID => 'Менеджер',
            CityManagerContract::FIELD_APPOINTMENT_DATE => 'Дата открытия',
        ];
    }
}
