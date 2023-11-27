<?php

namespace App\Repositories;

use App\Models\Goods\GoodsCategory;
use App\Repositories\Interfaces\GoodsCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GoodsCategoryRepository implements GoodsCategoryRepositoryInterface
{
    public function find($id)
    {
        return GoodsCategory::find($id);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return GoodsCategory::all();
    }

    public function getAllWithPagination($perPage)
    {
        return GoodsCategory::paginate($perPage);
    }
}
