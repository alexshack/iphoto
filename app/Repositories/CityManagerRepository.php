<?php

namespace App\Repositories;

use App\Contracts\Structure\CityManagerContract;
use App\Models\CityManagerHistory;
use App\Repositories\Interfaces\CityManagerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CityManagerRepository implements CityManagerRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return CityManagerHistory::all();
    }

    /**
     * Получение истории назначения менеджеров у города
     * @param int $cityId
     * @return Collection
     */
    public function getByCityId(int $cityId): Collection
    {
        return CityManagerHistory::where(CityManagerContract::FIELD_CITY_ID, '=', $cityId)
            ->orderBy(CityManagerContract::FIELD_APPOINTMENT_DATE, 'asc')
            ->get();
    }

    /**
     * Получение последнего (текущего) менеджера в городе
     * @param  int  $cityId
     * @return mixed
     */
    public function getLastManagerByCityId(int $cityId)
    {
        return CityManagerHistory::where(CityManagerContract::FIELD_CITY_ID, '=', $cityId)
            ->orderBy(CityManagerContract::FIELD_APPOINTMENT_DATE, 'desc')
            ->first();
    }
}
