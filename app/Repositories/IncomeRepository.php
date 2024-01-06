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
        $year = $data['year'] ?? null;
        $month = $data['month'] ?? null;
        $city = $data['city_id'] ?? null;

        $query = new Income;

        if ($year && !empty($year)) {
            $query = $query->whereYear(IncomeContract::FIELD_DATE, $year);
        }

        if ($month && !empty($month)) {
            $query = $query->whereMonth(IncomeContract::FIELD_DATE, $month);
        }

        if ($city) {
            $query = $query->where(IncomeContract::FIELD_CITY_ID, $city);
        }

        return $query->get();
    }
}
