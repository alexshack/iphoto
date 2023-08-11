<?php

namespace App\Repositories;

use App\Models\Money\Expense;
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

    public function find($id) {
        return Expense::find($id);
    }
}
