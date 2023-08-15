<?php

namespace App\Repositories;

use App\Contracts\Salary\CalcsTypeContract;
use App\Models\Salary\CalcsType;
use App\Repositories\Interfaces\CalcsTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CalcsTypeRepository implements CalcsTypeRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return CalcsType::all();
    }

    public function getAllAutomaticCalculation(): Collection
    {
        return CalcsType::where(CalcsTypeContract::FIELD_AUTOMATIC_CALCULATION, '=', 1)->get();
    }

    public function getAllManuallyCalculation(): Collection
    {
        return CalcsType::where(CalcsTypeContract::FIELD_AUTOMATIC_CALCULATION, '=', 0)->get();
    }
}
