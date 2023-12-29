<?php

namespace App\Repositories;

use App\Contracts\Structure\PlaceWorkTimeContract;
use App\Models\Structure\PlaceWorkTime;
use App\Repositories\Interfaces\PlaceWorkTimeRepositoryInterface;

class PlaceWorkTimeRepository implements PlaceWorkTimeRepositoryInterface
{

    public function find($id)
    {
        return PlaceWorkTime::find($id);
    }

    public function getAll()
    {
        return PlaceWorkTime::all();
    }

    public function getByPlaceID($id)
    {
        $builder = PlaceWorkTime::where(PlaceWorkTimeContract::FIELD_PLACE_ID, $id)
            ->orderBy(PlaceWorkTimeContract::FIELD_WEEK_DAY);
        return $builder->get();
    }

}
