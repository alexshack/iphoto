<?php

namespace App\Repositories;

use App\Models\Salary\EmployeeStatuses;
use App\Repositories\Interfaces\EmployeeStatusRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EmployeeStatusRepository implements EmployeeStatusRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return EmployeeStatuses::all();
    }
}
