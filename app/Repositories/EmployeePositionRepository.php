<?php

namespace App\Repositories;

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
}
