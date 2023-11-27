<?php

namespace App\Http\Livewire\GoodsCategory;

use App\Contracts\Goods\GoodsCategoryContract;
use App\Models\Goods\GoodsCategory;
use Livewire\Component;

class Edit extends Component
{
    public GoodsCategory $category;

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
        return view('livewire.goods-category.edit');
    }

    public function submit()
    {
        $this->validate();
        $this->category->save();
        session()->flash('message', 'Категория обновлена');
        return redirect()->route('admin.goods.categories.index')
            ->with(['message' => session('message')]);
    }
}
