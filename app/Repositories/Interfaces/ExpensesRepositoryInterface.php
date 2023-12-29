<?php

namespace App\Repositories\Interfaces;

use App\Models\WorkShift\WorkShift;

interface ExpensesRepositoryInterface
{
    public function getAll();
    public function getByWorkshift(WorkShift $workShift);
}
