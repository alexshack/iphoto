<?php

namespace App\Repositories\Interfaces;

use App\Models\WorkShift\WorkShift;

interface WorkShiftFinalCashDeskRepositoryInterface
{
    public function getAll();

    public function getByFilter($data);

    public function getByWorkShift(WorkShift $workShift);
}
