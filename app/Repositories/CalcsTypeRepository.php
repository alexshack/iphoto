<?php

namespace App\Repositories;

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
}
