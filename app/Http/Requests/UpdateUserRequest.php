<?php

namespace App\Http\Requests;

use App\Contracts\CityContract;
use App\Contracts\PositionContract;
use App\Contracts\UserContract;
use App\Contracts\UserPersonalDataContract;
use App\Contracts\UserWorkDataContract;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'user.' . UserContract::FIELD_EMAIL => [
                'email',
                'unique:' . UserContract::TABLE . ',' . UserContract::FIELD_EMAIL . ',' . $this->route('id'),
            ],
            'user.' . UserContract::FIELD_PHOTO => ['nullable', 'image', 'mimes:jpeg,jpg,webp', 'max:2048'],
            'personal.' . UserPersonalDataContract::FIELD_LAST_NAME => ['required', 'string', 'max:255'],
            'personal.' . UserPersonalDataContract::FIELD_FIRST_NAME => ['required', 'string', 'max:255'],
            'personal.' . UserPersonalDataContract::FIELD_MIDDLE_NAME => ['nullable', 'string', 'max:255'],
            'personal.' . UserPersonalDataContract::FIELD_PHONE => ['nullable', 'string', 'max:255'],
            'personal.' . UserPersonalDataContract::FIELD_PHONE_ADDITIONAL => ['nullable', 'string', 'max:255'],
            'personal.' . UserPersonalDataContract::FIELD_BIRTHDAY => ['nullable', 'date'],
            'personal.' . UserPersonalDataContract::FIELD_GENDER => ['nullable', 'numeric', 'in:1,2'],
            'personal.' . UserPersonalDataContract::FIELD_MARITAL_STATUS => ['nullable', 'numeric', 'in:1,2,3'],
            'personal.' . UserPersonalDataContract::FIELD_EDUCATION => ['nullable', 'numeric', 'in:1,2,3,4,5'],
            'personal.' . UserPersonalDataContract::FIELD_EMAIL => ['required', 'email'],
            'personal.' . UserPersonalDataContract::FIELD_REGISTERED_ADDRESS => ['required', 'string', 'max:255'],
            'personal.' . UserPersonalDataContract::FIELD_ADDRESS => ['required', 'string', 'max:255'],
            'work.' . UserWorkDataContract::FIELD_CITY_ID => ['required', 'integer', 'exists:' . CityContract::TABLE . ',' . CityContract::FIELD_ID],
            'work.' . UserWorkDataContract::FIELD_POSITION_ID => ['nullable', 'integer', 'exists:' . PositionContract::TABLE . ',' . PositionContract::FIELD_ID],
            'work.' . UserWorkDataContract::FIELD_STATUS => ['nullable', 'numeric', 'in:1,2,3,4,5'],
            'work.' . UserWorkDataContract::FIELD_DATE_OF_EMPLOYMENT => ['nullable', 'date'],
            'work.' . UserWorkDataContract::FIELD_DATE_OF_TERMINATION => ['nullable', 'date'],
        ];
    }

    public function attributes()
    {
        return [
            'user.' . UserContract::FIELD_EMAIL => 'E-mail',
            'user.' . UserContract::FIELD_PHOTO => 'Фотография',
            'personal.' . UserPersonalDataContract::FIELD_LAST_NAME => 'Фамилия',
            'personal.' . UserPersonalDataContract::FIELD_FIRST_NAME => 'Имя',
            'personal.' . UserPersonalDataContract::FIELD_MIDDLE_NAME => 'Отчество',
            'personal.' . UserPersonalDataContract::FIELD_PHONE => 'Номер',
            'personal.' . UserPersonalDataContract::FIELD_PHONE_ADDITIONAL => 'Дополнительный номер',
            'personal.' . UserPersonalDataContract::FIELD_BIRTHDAY => 'День рождения',
            'personal.' . UserPersonalDataContract::FIELD_GENDER => 'Пол',
            'personal.' . UserPersonalDataContract::FIELD_MARITAL_STATUS => 'Семейное положение',
            'personal.' . UserPersonalDataContract::FIELD_EDUCATION => 'Образование',
            'personal.' . UserPersonalDataContract::FIELD_EMAIL => 'E-mail',
            'personal.' . UserPersonalDataContract::FIELD_REGISTERED_ADDRESS => 'Адрес регистрации',
            'personal.' . UserPersonalDataContract::FIELD_ADDRESS => 'Адрес проживания',
            'work.' . UserWorkDataContract::FIELD_CITY_ID => 'Город',
            'work.' . UserWorkDataContract::FIELD_POSITION_ID => 'Должность',
            'work.' . UserWorkDataContract::FIELD_DATE_OF_EMPLOYMENT => 'Дата приема',
            'work.' . UserWorkDataContract::FIELD_DATE_OF_TERMINATION => 'Дата увольнения',
        ];
    }
}
