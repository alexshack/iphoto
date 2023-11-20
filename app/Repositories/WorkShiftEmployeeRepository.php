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

    public function companions(WorkShiftEmployee $employee, $positions = []) {
        $builder = WorkShiftEmployee::where(WorkShiftEmployeeContract::FIELD_WORK_SHIFT_ID, $employee->{WorkShiftEmployeeContract::FIELD_WORK_SHIFT_ID})
            ->whereIn(WorkShiftEmployeeContract::FIELD_POSITION_ID, $positions)
            ->where(WorkShiftEmployeeContract::FIELD_ID, '!=', $employee->{WorkShiftEmployeeContract::FIELD_ID})
            ->where(function ($query) use ($employee) {
                $query->where(WorkShiftEmployeeContract::FIELD_START_TIME, '<', $employee->{WorkShiftEmployeeContract::FIELD_END_TIME})
                    ->where(WorkShiftEmployeeContract::FIELD_START_TIME, '>', $employee->{WorkShiftEmployeeContract::FIELD_START_TIME});
            });
        return $builder->get();
    }

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

    public function getBySameWithdrawalPeriod($workShiftID, $startTime, $endTime, $positions = [], $placeWorkStartTime = null)
    {
        if (!$placeWorkStartTime) {
            $placeWorkStartTime = Carbon::parse('08:00:00');
        }

        $positions = array_map(function ($item) {
            return (int) $item;
        }, $positions);

        $builder = WorkShiftEmployee::where(function ($query) use ($startTime, $endTime, $placeWorkStartTime) {
            //if ($placeWorkStartTime->lessThanOrEqualTo($startTime) && $placeWorkStartTime->lessThanOrEqualTo($endTime)) {
            $query->where(function ($query) use ($startTime, $endTime) {
                $query->where(WorkShiftEmployeeContract::FIELD_START_TIME, '>', $startTime)
                    ->where(WorkShiftEmployeeContract::FIELD_START_TIME, '<', $endTime);
            })->orWhere(function ($query) use ($startTime, $endTime) {
                $query->where(WorkShiftEmployeeContract::FIELD_END_TIME, '>', $startTime)
                    ->where(WorkShiftEmployeeContract::FIELD_END_TIME, '<', $endTime);
            });
        })
            ->where(WorkShiftEmployeeContract::FIELD_WORK_SHIFT_ID, $workShiftID);

        if (count($positions) > 0) {
            if (count($positions) === 1) {
                $builder->where(WorkShiftEmployeeContract::FIELD_POSITION_ID, $positions[0]);
            } else {
                $builder->whereIn(WorkShiftEmployeeContract::FIELD_POSITION_ID, $positions);
            }
        }
        return $builder->get();
    }
}
