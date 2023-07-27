<?php

namespace App\Repositories\Interfaces;

interface CityManagerRepositoryInterface
{
    public function getAll();

    public function getByCityId(int $cityId);

    public function getLastManagerByCityId(int $cityId);
}
