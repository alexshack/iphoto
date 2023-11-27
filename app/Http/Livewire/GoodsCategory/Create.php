<?php

namespace App\Http\Livewire\GoodsCategory;

use App\Contracts\Goods\GoodsCategoryContract;
use App\Models\Goods\GoodsCategory;
use Livewire\Component;

class Create extends Component
{
    public $category = [];

    public function getValidationAttributes()
    {
        $attributes = [];
        foreach (GoodsCategoryContract::ATTRIBUTES as $key => $attr) {
            $attributes["category.$key"] = $attr;
        }
        return $attributes;
    }

    public function getRules()
    {
        $rules = [];
        foreach (GoodsCategoryContract::RULES as $key => $rule) {
            $rules["category.$key"] = $rule;
        }
        return $rules;
    }

    public function render()
    {
        return view('livewire.goods-category.create');
    }

    public function submit()
    {
        $this->validate();
        $category = GoodsCategory::create($this->category);
        if ($category) {
            return redirect()->route('admin.goods.categories.edit', ['id' => $category->id]);
        }
    }
}
