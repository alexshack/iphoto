<?php

namespace App\Repositories;

use App\Contracts\Structure\PlaceContract;
use App\Models\Structure\Place;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PlaceRepository implements PlaceRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Place::all();
    }

    public function getOpen(): Collection
    {
        return Place::where(PlaceContract::FIELD_STATUS, 1)->get();
    }

    public function getByCityId($cityId): Collection
    {
        return Place::where(PlaceContract::FIELD_CITY_ID, '=', $cityId)->get();
    }
}
