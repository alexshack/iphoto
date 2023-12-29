<?php

namespace App\Observers;

use App\Contracts\WorkShift\WorkShiftWithdrawalContract;
use App\Contracts\WorkShift\WorkShiftEmployeeContract;
use App\Models\WorkShift\WorkShiftEmployee;
use App\Models\WorkShift\WorkShiftWithdrawal;
use Carbon\Carbon;

class WorkShiftEmployeeObserver
{
    protected $afterCommit = true;

    /**
     * Handle the WorkShiftEmployee "created" event.
     */
    public function created(WorkShiftEmployee $workShiftEmployee): void
    {
        $this->checkWithdrawal($workShiftEmployee);
        $this->updateWorkTime($workShiftEmployee);
    }

    /**
     * Handle the WorkShiftEmployee "updated" event.
     */
    public function updated(WorkShiftEmployee $workShiftEmployee): void
    {
        $this->checkWithdrawal($workShiftEmployee);
        $this->updateWorkTime($workShiftEmployee);
    }

    /**
     * Handle the WorkShiftEmployee "deleted" event.
     */
    public function deleted(WorkShiftEmployee $workShiftEmployee): void
    {
        //
    }

    /**
     * Handle the WorkShiftEmployee "restored" event.
     */
    public function restored(WorkShiftEmployee $workShiftEmployee): void
    {
        //
    }

    /**
     * Handle the WorkShiftEmployee "force deleted" event.
     */
    public function forceDeleted(WorkShiftEmployee $workShiftEmployee): void
    {
        //
    }

    protected function checkWithdrawal($workShiftEmployee) {
        if ($workShiftEmployee->{WorkShiftEmployeeContract::FIELD_START_TIME}) {
            $withdrawal = WorkShiftWithdrawal::where(WorkShiftWithdrawalContract::FIELD_WORK_SHIFT_ID, $workShiftEmployee->{WorkShiftEmployeeContract::FIELD_WORK_SHIFT_ID})
                ->where(WorkShiftWithdrawalContract::FIELD_TIME, $workShiftEmployee->{WorkShiftEmployeeContract::FIELD_START_TIME})
                ->first();

            if (!$withdrawal) {
                WorkShiftWithdrawal::create([
                    WorkShiftWithdrawalContract::FIELD_WORK_SHIFT_ID => $workShiftEmployee->{WorkShiftEmployeeContract::FIELD_WORK_SHIFT_ID},
                    WorkShiftWithdrawalContract::FIELD_TIME => $workShiftEmployee->{WorkShiftEmployeeContract::FIELD_START_TIME},
                ]);
            }
        }

        if ($workShiftEmployee->{WorkShiftEmployeeContract::FIELD_END_TIME}) {
            $withdrawal = WorkShiftWithdrawal::where(WorkShiftWithdrawalContract::FIELD_WORK_SHIFT_ID, $workShiftEmployee->{WorkShiftEmployeeContract::FIELD_WORK_SHIFT_ID})
                ->where(WorkShiftWithdrawalContract::FIELD_TIME, $workShiftEmployee->{WorkShiftEmployeeContract::FIELD_END_TIME})
                ->first();

            if (!$withdrawal) {
                WorkShiftWithdrawal::create([
                    WorkShiftWithdrawalContract::FIELD_WORK_SHIFT_ID => $workShiftEmployee->{WorkShiftEmployeeContract::FIELD_WORK_SHIFT_ID},
                    WorkShiftWithdrawalContract::FIELD_TIME => $workShiftEmployee->{WorkShiftEmployeeContract::FIELD_END_TIME},
                ]);
            }
        }
    }

    protected function updateWorkTime(WorkShiftEmployee $workShiftEmployee) {
        if (!$workShiftEmployee->{WorkShiftEmployeeContract::FIELD_START_TIME} || !$workShiftEmployee->{WorkShiftEmployeeContract::FIELD_END_TIME}) {
            return;
        }
        $startTime = Carbon::parse($workShiftEmployee->{WorkShiftEmployeeContract::FIELD_START_TIME});
        $endTime = Carbon::parse($workShiftEmployee->{WorkShiftEmployeeContract::FIELD_END_TIME});

        $start = Carbon::createFromTimeString($startTime);
        $end = Carbon::createFromTimeString($endTime);

        $placeStartTime = null;
        if (!$placeStartTime) {
            $placeStartTime = Carbon::parse($workShiftEmployee->workShift->start_time);
        }

        $d = 0;
        $midnight = Carbon::parse('00:00:00');

        if ($endTime->lessThan($placeStartTime) && $startTime->greaterThan($placeStartTime)) {
            $midnightDiff = $midnight->diffInMinutes($startTime);
            $d = 24 * 60 - $midnightDiff;
            $d += $endTime->diffInMinutes($midnight);
        } else {
            $d = $start->diffInMinutes($end);
        }

        $workShiftEmployee->{WorkShiftEmployeeContract::FIELD_WORK_TIME} = $d;
        $workShiftEmployee->saveQuietly();
    }
}
