<?php

namespace App\Repositories;

use App\Models\Goods\GoodsCategory;
use App\Repositories\Interfaces\GoodsCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GoodsCategoryRepository implements GoodsCategoryRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return GoodsCategory::all();
    }
}
