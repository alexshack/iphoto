<?php

namespace App\Repositories;

use App\Contracts\Salary\CalcsContract;
use App\Models\Salary\Calc;
use App\Repositories\Interfaces\CalcsRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CalcsRepository implements CalcsRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Calc::all();
    }

    public function find($id) {
        return Calc::find($id);
    }

    public function getByFilter($data): Collection {
        return Calc::whereYear(CalcsContract::FIELD_DATE, $data['year'])
            ->whereMonth(CalcsContract::FIELD_DATE, $data['month'])
            ->get();
    }
}
