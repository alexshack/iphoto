<?php

namespace App\Repositories;

use App\Contracts\Salary\CalcsTypeContract;
use App\Models\Salary\CalcsType;
use App\Repositories\Interfaces\CalcsTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CalcsTypeRepository implements CalcsTypeRepositoryInterface
{
    public function getActive() {
        return CalcsType::where(CalcsTypeContract::FIELD_STATUS, true)->get();
    }
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
        return CalcsType::where(CalcsTypeContract::FIELD_AUTOMATIC_CALCULATION, '=', 0)
            ->orWhereNull(CalcsTypeContract::FIELD_AUTOMATIC_CALCULATION)
            ->get();
    }

    public function getByTypeLast($type)
    {
        return CalcsType::where(CalcsTypeContract::FIELD_TYPE, $type)
            ->orderBy(CalcsTypeContract::FIELD_ID, 'desc')
            ->first();
    }

    public function getByIDs($arr = [])
    {
        return CalcsType::whereIn(CalcsTypeContract::FIELD_ID, $arr)
            ->get();
    }
}
