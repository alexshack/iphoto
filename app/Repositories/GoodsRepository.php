<?php

namespace App\Repositories;

use App\Models\Goods\Goods;
use App\Contracts\Goods\GoodsContract;
use App\Repositories\Interfaces\GoodsRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GoodsRepository implements GoodsRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Goods::all();
    }

    public function getByType($type) {
        return Goods::where(GoodsContract::FIELD_TYPE, $type)->get();
    }
}
