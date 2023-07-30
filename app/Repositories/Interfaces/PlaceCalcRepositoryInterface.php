<?php

namespace App\Repositories\Interfaces;

interface PlaceCalcRepositoryInterface
{
    public function getAll();

    public function getByPlaceId($id);
}
