<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\Contracts\UserPersonalDataContract;
use App\Contracts\WorkShift\WorkShiftEmployeeContract;
use App\Models\WorkShift\WorkShiftEmployee;
use App\Repositories\Interfaces\WorkShiftEmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class WorkShiftEmployeeRepository implements WorkShiftEmployeeRepositoryInterface
{

    public function find($id) {
        return WorkShiftEmployee::find($id);
    }

    /**
     * @return Collection
     */
    public function getAll($workShiftID): Collection
    {
        return WorkShiftEmployee::where(WorkShiftEmployeeContract::FIELD_WORK_SHIFT_ID, $workShiftID)
            ->with([
                'user:' . UserContract::FIELD_ID . ',' . UserContract::FIELD_PHOTO,
                'user.personalData:' . UserContract::FIELD_ID . ',' . UserPersonalDataContract::FIELD_USER_ID . ',' . UserPersonalDataContract::FIELD_LAST_NAME . ',' .UserPersonalDataContract::FIELD_FIRST_NAME . ',' .UserPersonalDataContract::FIELD_MIDDLE_NAME,
                'position',
                'status',
            ])
            ->get();
    }
}
