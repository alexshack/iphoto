<?php

namespace App\Repositories\Interfaces;

interface EmployeePositionRepositoryInterface
{
    public function getAll();

    public function getActive();
}
