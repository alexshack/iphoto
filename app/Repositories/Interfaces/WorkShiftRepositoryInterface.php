<?php

namespace App\Repositories\Interfaces;

interface WorkShiftRepositoryInterface
{
    public function getAll();

    public function getByFilter($data);
}
