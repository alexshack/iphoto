<?php

namespace App\Repositories\Interfaces;

interface MovesRepositoryInterface
{
    public function getAll();

    public function getByFilter($data);
}
