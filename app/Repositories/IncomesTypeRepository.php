<?php

namespace App\Repositories;

use App\Models\Money\IncomesType;
use App\Repositories\Interfaces\IncomesTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class IncomesTypeRepository implements IncomesTypeRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return IncomesType::all();
    }
}
