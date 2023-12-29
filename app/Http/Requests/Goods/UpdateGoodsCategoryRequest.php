<?php

namespace App\Http\Requests\Goods;

use App\Contracts\Goods\GoodsCategoryContract;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGoodsCategoryRequest extends FormRequest
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
        return GoodsCategoryContract::RULES;
    }

    public function attributes()
    {
        return GoodsCategoryContract::ATTRIBUTES;
    }
}
