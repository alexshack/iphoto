<?php

namespace App\Repositories;

use App\Contracts\Money\MovesContract;
use App\Models\Money\Move;
use App\Repositories\Interfaces\MovesRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class MovesRepository implements MovesRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Move::all();
    }

    public function getByFilter($data): Collection {
        return Move::whereYear(MovesContract::FIELD_DATE, $data['year'])
            ->whereMonth(MovesContract::FIELD_DATE, $data['month'])
            ->get();
    }

    public function find($id) {
        return Move::find($id);
    }
}
