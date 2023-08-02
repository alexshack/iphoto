<?php

namespace App\Repositories;

use App\Models\Goods\Goods;
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
}
