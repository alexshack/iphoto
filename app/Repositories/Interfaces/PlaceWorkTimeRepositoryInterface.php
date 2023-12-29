<?php

namespace App\Repositories\Interfaces;

interface PlaceWorkTimeRepositoryInterface
{
    public function getAll();

    public function getByPlaceID($id);
}
