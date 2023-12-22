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

    public function getCount()
    {
        return Place::count();
    }

    public function getOpen(): Collection
    {
        return Place::where(PlaceContract::FIELD_STATUS, 1)->get();
    }

    public function getByCityId($cityId): Collection
    {
        return Place::where(PlaceContract::FIELD_CITY_ID, '=', $cityId)->get();
    }

    public function getByIds($ids = []): Collection
    {
        return Place::whereIn(PlaceContract::FIELD_ID, $ids)->get();
    }
}
