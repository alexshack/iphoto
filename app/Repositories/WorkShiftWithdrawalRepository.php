<?php

namespace App\Repositories;

use App\Contracts\WorkShift\WorkShiftWithdrawalContract;
use App\Models\WorkShift\WorkShiftWithdrawal;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class WorkShiftWithdrawalRepository implements WorkShiftWithdrawalRepositoryInterface
{

    public function find($id) {
        return WorkShiftWithdrawal::find($id);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return WorkShiftWithdrawal::all();
    }

    public function getByFilter($data): Collection
    {
        return WorkShiftWithdrawal::whereYear(WorkShiftContract::FIELD_DATE, $data['year'])
            ->whereMonth(WorkShiftContract::FIELD_DATE, $data['month'])
            ->get();
    }
}
