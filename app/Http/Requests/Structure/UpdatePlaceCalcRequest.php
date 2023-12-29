<?php

namespace App\Http\Requests\Structure;

use App\Contracts\Structure\PlaceCalcContract;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePlaceCalcRequest extends FormRequest
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
        return PlaceCalcContract::RULES;
    }

    public function attributes()
    {
        return PlaceCalcContract::ATTRIBUTES;
    }
}
