<?php

namespace App\Repositories;

use App\Contracts\WorkShift\WorkShiftContract;
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

    public function getByWorkShift($workShift)
    {
        return WorkShiftFinalCashDesk::where(WorkShiftFinalCashDeskContract::FIELD_WORK_SHIFT_ID, $workShift->{WorkShiftContract::FIELD_ID})
            ->with('saleType')
            ->get();
    }

    public function getByFilter($data): Collection
    {
        return WorkShiftFinalCashDesk::whereYear(WorkShiftContract::FIELD_DATE, $data['year'])
            ->whereMonth(WorkShiftContract::FIELD_DATE, $data['month'])
            ->get();
    }
}
