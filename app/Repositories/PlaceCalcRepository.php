<?php

namespace App\Repositories;

use App\Contracts\Structure\PlaceCalcContract;
use App\Models\Structure\PlaceCalc;
use App\Repositories\Interfaces\PlaceCalcRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class PlaceCalcRepository implements PlaceCalcRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return PlaceCalc::all();
    }

    public function getByPlaceId($id)
    {
        return PlaceCalc::where(PlaceCalcContract::FIELD_PLACE_ID, '=', $id)->orderBy(PlaceCalcContract::FIELD_START_DATE, 'asc')->get();
    }

    public function getActiveByPlaceId($id)
    {
        return PlaceCalc::where(PlaceCalcContract::FIELD_PLACE_ID, '=', $id)
            ->whereDate(PlaceCalcContract::FIELD_START_DATE, '<=', Carbon::now())
            ->whereDate(PlaceCalcContract::FIELD_END_DATE, '>=', Carbon::now())
            ->orderBy(PlaceCalcContract::FIELD_START_DATE, 'asc')
            ->get();
    }
}
