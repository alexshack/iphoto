<?php

namespace App\Repositories\Interfaces;

interface PlaceRepositoryInterface
{
    public function getAll();

    public function getByCityId($cityId);
}
