<?php

namespace App\Http\Livewire\GoodsCategory;

use App\Repositories\GoodsCategoryRepository;
use App\Models\Goods\GoodsCategory;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    protected GoodsCategoryRepository $goodsCategoryRepository;

    public function render(GoodsCategoryRepository $goodsCategoryRepository)
    {
        $this->goodsCategoryRepository = $goodsCategoryRepository;
        return view('livewire.goods-category.index', [
            'categories' => $this->goodsCategoryRepository->getAllWithPagination(40),
        ]);
    }

    public function destroyCategory($id)
    {
        $category = GoodsCategory::find($id);
        if ($category) {
            $category->delete();
            $this->emit('$refresh');
        }
    }
}
