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

    public function find($id) {
        return Goods::find($id);
    }

    public function getByType($type) {
        return Goods::where(GoodsContract::FIELD_TYPE, $type)->get();
    }

    public function getTMCByPlaceID($placeID, $paginate = false)
    {
        $builder = Goods::where(GoodsContract::FIELD_PLACE_ID, $placeID)
            ->where(GoodsContract::FIELD_TYPE, 3);

        if ($paginate) {
            return $builder->paginate($paginate);
        } else {
            return $builder->get();
        }
    }
}
