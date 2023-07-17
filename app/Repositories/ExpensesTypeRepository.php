<?php

namespace App\Repositories;

use App\Models\Money\ExpensesType;
use App\Repositories\Interfaces\ExpensesTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ExpensesTypeRepository implements ExpensesTypeRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return ExpensesType::all();
    }
}
