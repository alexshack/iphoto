<?php

namespace App\Http\Requests\Goods;

use App\Contracts\Goods\GoodsContract;
use Illuminate\Foundation\Http\FormRequest;

class CreateGoodsRequest extends FormRequest
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
        return GoodsContract::RULES;
    }

    public function attributes()
    {
        return GoodsContract::ATTRIBUTES;
    }
}
