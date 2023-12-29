<?php

namespace App\Observers\WorkShift;

use App\Contracts\WorkShift\WorkShiftContract;
use App\Contracts\WorkShift\WorkShiftVisitorContract;
use App\Models\WorkShift\WorkShift;
use App\Models\WorkShift\WorkShiftVisitor;

class WorkShiftVisitorObserver
{
    /**
     * Handle the WorkShiftVisitor "created" event.
     */
    public function created(WorkShiftVisitor $workShiftVisitor): void
    {
        //
    }

    /**
     * Handle the WorkShiftVisitor "updated" event.
     */
    public function updated(WorkShiftVisitor $workShiftVisitor): void
    {
        $workShift = WorkShift::find($workShiftVisitor->{WorkShiftVisitorContract::FIELD_WORK_SHIFT_ID});
        if ($workShift) {
            $visitorsSum = WorkShiftVisitor::where(WorkShiftVisitorContract::FIELD_WORK_SHIFT_ID, $workShiftVisitor->{WorkShiftVisitorContract::FIELD_WORK_SHIFT_ID})
                ->sum(WorkShiftVisitorContract::FIELD_TOTAL);
            $workShift->{WorkShiftContract::FIELD_VISITORS_TOTAL} = $visitorsSum;
            $workShift->saveQuietly();
        }
    }

    /**
     * Handle the WorkShiftVisitor "deleted" event.
     */
    public function deleted(WorkShiftVisitor $workShiftVisitor): void
    {
        //
    }

    /**
     * Handle the WorkShiftVisitor "restored" event.
     */
    public function restored(WorkShiftVisitor $workShiftVisitor): void
    {
        //
    }

    /**
     * Handle the WorkShiftVisitor "force deleted" event.
     */
    public function forceDeleted(WorkShiftVisitor $workShiftVisitor): void
    {
        //
    }
}
