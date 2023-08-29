<?php

namespace App\Repositories;

use App\Contracts\Salary\PaysContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Models\Salary\Pay;
use App\Models\WorkShift\WorkShift;
use App\Repositories\Interfaces\PaysRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PaysRepository implements PaysRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Pay::all();
    }

    public function find($id) {
        return Pay::find($id);
    }

    public function getByFilter($data): Collection {
        return Pay::whereYear(PaysContract::FIELD_DATE, $data['year'])
            ->whereMonth(PaysContract::FIELD_DATE, $data['month'])
            ->get();
    }

    public function getByWorkshift(WorkShift $workShift, $type = null) {
        $pays = Pay::whereDate(PaysContract::FIELD_DATE, $workShift->{WorkShiftContract::FIELD_DATE})
            ->where(PaysContract::FIELD_PLACE_ID, $workShift->{WorkShiftContract::FIELD_PLACE_ID})
            ->where(PaysContract::FIELD_CITY_ID, $workShift->{WorkShiftContract::FIELD_CITY_ID});

        if ($type) {
            $pays = $pays->where(PaysContract::FIELD_TYPE, $type);
        }
        return $pays->get();

    }
}
