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
        $date = $workShift->{WorkShiftContract::FIELD_DATE};
        $place = $workShift->{WorkShiftContract::FIELD_PLACE_ID};
        $city = $workShift->{WorkShiftContract::FIELD_CITY_ID};

        $query = new Expense;

        if ($date) {
            $query = $query->whereDate(ExpenseContract::FIELD_DATE, $date);
        }

        if ($place) {
            $query = $query->where(ExpenseContract::FIELD_PLACE_ID, $place);
        }

        if ($city) {
            $query = $query->where(ExpenseContract::FIELD_CITY_ID, $city);
        }

        $expenses = $query
            ->with(
                'expenseType',
                'city',
                'place',
                'manager'
            )
            ->get();

        return $expenses;
    }

    public function find($id) {
        return Expense::find($id);
    }
}
