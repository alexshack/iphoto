<?php

namespace App\Repositories;

use App\Contracts\WorkShift\WorkShiftContract;
use App\Models\WorkShift\WorkShift;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
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
}
