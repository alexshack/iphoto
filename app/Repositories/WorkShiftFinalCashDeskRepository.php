<?php

namespace App\Repositories;

use App\Contracts\WorkShift\WorkShiftFinalCashDeskContract;
use App\Models\WorkShift\WorkShiftFinalCashDesk;
use App\Repositories\Interfaces\WorkShiftFinalCashDeskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class WorkShiftFinalCashDeskRepository implements WorkShiftFinalCashDeskRepositoryInterface
{

    public function find($id) {
        return WorkShiftFinalCashDesk::find($id);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return WorkShiftFinalCashDesk::all();
    }

    public function getByWorkShift($workShiftID)
    {
        return WorkShiftFinalCashDesk::where(WorkShiftFinalCashDeskContract::FIELD_WORK_SHIFT_ID, $workShiftID)->get();
    }

    public function getByFilter($data): Collection
    {
        return WorkShiftFinalCashDesk::whereYear(WorkShiftContract::FIELD_DATE, $data['year'])
            ->whereMonth(WorkShiftContract::FIELD_DATE, $data['month'])
            ->get();
    }
}
