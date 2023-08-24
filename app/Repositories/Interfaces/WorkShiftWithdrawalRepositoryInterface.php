<?php

namespace App\Repositories\Interfaces;

interface WorkShiftWithdrawalRepositoryInterface
{
    public function getAll();

    public function getByFilter($data);
}
