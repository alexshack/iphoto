<?php

namespace App\Repositories\Interfaces;

interface WorkShiftGoodsRepositoryInterface
{
    public function find($id);

    public function getAll($workShiftID);
}
