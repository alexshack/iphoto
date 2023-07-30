<?php

namespace App\Repositories;

use App\Contracts\PositionContract;
use App\Models\Salary\Position;
use App\Repositories\Interfaces\EmployeePositionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EmployeePositionRepository implements EmployeePositionRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Position::all();
    }

    public function getActive()
    {
        return Position::where(PositionContract::FIELD_STATUS, '=', 1)->get();
    }
}
