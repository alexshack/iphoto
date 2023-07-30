<?php

namespace App\Repositories;

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
}
