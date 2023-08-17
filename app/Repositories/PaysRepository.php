<?php

namespace App\Repositories;

use App\Contracts\Salary\PaysContract;
use App\Models\Salary\Pay;
use App\Repositories\Interfaces\PaysRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PaysRepository implements PaysRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Pay::all();
    }

    public function find($id) {
        return Pay::find($id);
    }

    public function getByFilter($data): Collection {
        return Pay::whereYear(PaysContract::FIELD_DATE, $data['year'])
            ->whereMonth(PaysContract::FIELD_DATE, $data['month'])
            ->get();
    }
}
