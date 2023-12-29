<?php

namespace App\Repositories;

use App\Contracts\WorkShift\WorkShiftPayrollContract;
use App\Models\WorkShift\WorkShiftPayroll;
use App\Repositories\Interfaces\WorkShiftPayrollRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class WorkShiftPayrollRepository implements WorkShiftPayrollRepositoryInterface
{
    public function getByWorkShiftID($workShiftID)
    {
        return WorkShiftPayroll::where(WorkShiftPayrollContract::FIELD_WORK_SHIFT_ID, $workShiftID)->get();
    }
}
