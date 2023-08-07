<?php

namespace App\Repositories;

use App\Contracts\Structure\CityContract;
use App\Models\City;
use App\Repositories\Interfaces\CityRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CityRepository implements CityRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return City::all();
    }
}
