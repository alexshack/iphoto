<?php

namespace App\Repositories\Interfaces;

interface IncomeRepositoryInterface
{
    public function getAll();

    public function getByFilter($data);
}
