<?php

namespace App\Http\Requests\Salary;

use App\Contracts\Salary\CalcsTypeContract;
use Illuminate\Foundation\Http\FormRequest;

class CreateCalcTypeRequest extends FormRequest
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
        $validation = [
            CalcsTypeContract::FIELD_NAME => 'required|string|max:255',
            CalcsTypeContract::FIELD_STATUS => 'required|numeric|in:1,2',
            CalcsTypeContract::FIELD_AUTOMATIC_CALCULATION => 'sometimes',
            CalcsTypeContract::FIELD_SALARY_PAYMENT => 'sometimes',
            CalcsTypeContract::FIELD_CUSTOM_DATA => 'required|array|min:1',
        ];

        if ($this->input(CalcsTypeContract::FIELD_TYPE) === 3) {
            $validation[CalcsTypeContract::FIELD_CUSTOM_DATA . ".employee_statuses"] = 'required|array|min:1';
        }

        if ($this->input(CalcsTypeContract::FIELD_TYPE) === 5) {
            $validation[CalcsTypeContract::FIELD_CUSTOM_DATA . ".positions"] = 'required|array|min:1';
        }

        if(isset(CalcsTypeContract::TYPE_LIST[ $this->input( CalcsTypeContract::FIELD_TYPE ) ])) {
            foreach(CalcsTypeContract::TYPE_LIST[ $this->input( CalcsTypeContract::FIELD_TYPE ) ]['fields'] as $item) {
                $validation[ $item['validation_field'] ] = $item['rules'];
            }
        }

        return $validation;
    }

    public function attributes()
    {
        $attributes = [
            CalcsTypeContract::FIELD_NAME => 'Название',
            CalcsTypeContract::FIELD_STATUS => 'Статус',
            CalcsTypeContract::FIELD_AUTOMATIC_CALCULATION => 'Участие в автоматическом расчете',
            CalcsTypeContract::FIELD_SALARY_PAYMENT => 'Участие в выплате оклада',
            CalcsTypeContract::FIELD_CUSTOM_DATA => 'Настройки',
        ];

        foreach(CalcsTypeContract::TYPE_LIST as $item) {
            if(!empty($item['fields'])) {
                foreach($item['fields'] as $field) {
                    $attributes[ CalcsTypeContract::FIELD_CUSTOM_DATA . '.' . $field['name'] ] = $field['attribute'];
                }
            }
        }

        return $attributes;
    }
}
