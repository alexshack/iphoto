<?php

namespace App\Repositories;

use App\Contracts\WorkShift\WorkShiftContract;
use App\Models\WorkShift\WorkShift;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class WorkShiftRepository implements WorkShiftRepositoryInterface
{

    public function find($id) {
        return WorkShift::with('employees')
            ->where('id', $id)
            ->first();
    }
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return WorkShift::all();
    }

    public function getByFilter($data): Collection
    {
        return WorkShift::whereYear(WorkShiftContract::FIELD_DATE, $data['year'])
            ->whereMonth(WorkShiftContract::FIELD_DATE, $data['month'])
            ->get();
    }

    public function getNext(WorkShift $workshift) {
        return WorkShift::where(WorkShiftContract::FIELD_PLACE_ID, $workshift->{WorkShiftContract::FIELD_PLACE_ID
    })
        ->where(WorkShiftContract::FIELD_CITY_ID, $workshift->{WorkShiftContract::FIELD_CITY_ID})
        ->where(WorkShiftContract::FIELD_ID, '>', $workshift->{WorkShiftContract::FIELD_ID})
        ->first();
    }

    public function getToday(): Collection
    {
        return WorkShift::whereDate('created_at', Carbon::today())->get();
    }
}
