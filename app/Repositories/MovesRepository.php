<?php

namespace App\Repositories;

use App\Contracts\Money\MovesContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Models\Money\Move;
use App\Models\WorkShift\WorkShiftGood;
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

    public function getByWorkshift(WorkShift $workShift) {
        $moves = Move::whereData(MovesContract::FIELD_DATE, $workShift->{WorkShiftContract::FIELD_DATE})
            ->where(MovesContract::FIELD_PLACE_ID, $workShift->{WorkShiftContract::FIELD_PLACE_ID})
            ->where(MovesContract::FIELD_CITY_ID, $workShift->{WorkShiftContract::FIELD_CITY_ID})
            ->get();
        return $moves;
    }

    public function find($id) {
        return Move::find($id);
    }
}
