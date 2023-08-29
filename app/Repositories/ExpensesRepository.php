<?php

namespace App\Repositories;

use App\Contracts\Money\ExpenseContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Models\Money\Expense;
use App\Models\WorkShift\WorkShift;
use App\Repositories\Interfaces\ExpensesRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ExpensesRepository implements ExpensesRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Expense::all();
    }

    public function getByWorkshift(WorkShift $workShift) {
        $expenses = Expense::whereDate(ExpenseContract::FIELD_DATE, $workShift->{WorkShiftContract::FIELD_DATE})
            ->where(ExpenseContract::FIELD_PLACE_ID, $workShift->{WorkShiftContract::FIELD_PLACE_ID})
            ->where(ExpenseContract::FIELD_CITY_ID, $workShift->{WorkShiftContract::FIELD_CITY_ID})
            ->get();
        return $expenses;
    }

    public function find($id) {
        return Expense::find($id);
    }
}
