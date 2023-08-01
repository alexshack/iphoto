<?php

namespace App\Http\Requests\Structure;

use App\Contracts\Structure\PlaceContract;
use Illuminate\Foundation\Http\FormRequest;

class CreatePlaceRequest extends FormRequest
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
        return PlaceContract::RULES;
    }

    public function attributes()
    {
        return PlaceContract::ATTRIBUTES;
    }
}
