<?php

namespace App\Repositories;

use App\Contracts\Money\IncomeContract;
use App\Models\Money\Income;
use App\Repositories\Interfaces\IncomeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class IncomeRepository implements IncomeRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Income::all();
    }

    public function getByFilter($data): Collection
    {
        return Income::whereYear(IncomeContract::FIELD_DATE, $data['year'])
            ->whereMonth(IncomeContract::FIELD_DATE, $data['month'])
            ->get();
    }
}
