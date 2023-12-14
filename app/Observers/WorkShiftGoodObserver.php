<?php

namespace App\Observers;

use App\Contracts\Goods\GoodsContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Contracts\WorkShift\WorkShiftGoodsContract;
use App\Models\WorkShift\WorkShift;
use App\Models\WorkShift\WorkShiftGood;

class WorkShiftGoodObserver
{
    public $afterCommit = true;
    /**
     * Handle the WorkShiftGood "created" event.
     */
    public function created(WorkShiftGood $workShiftGood): void
    {
        $this->recalculateCheckAverage($workShiftGood->{WorkShiftGoodsContract::FIELD_WORK_SHIFT_ID});
    }

    /**
     * Handle the WorkShiftGood "updated" event.
     */
    public function updated(WorkShiftGood $workShiftGood): void
    {
        $this->recalculateCheckAverage($workShiftGood->{WorkShiftGoodsContract::FIELD_WORK_SHIFT_ID});
    }

    /**
     * Handle the WorkShiftGood "deleted" event.
     */
    public function deleted(WorkShiftGood $workShiftGood): void
    {
        //
    }

    /**
     * Handle the WorkShiftGood "restored" event.
     */
    public function restored(WorkShiftGood $workShiftGood): void
    {
        //
    }

    /**
     * Handle the WorkShiftGood "force deleted" event.
     */
    public function forceDeleted(WorkShiftGood $workShiftGood): void
    {
        //
    }

    protected function recalculateCheckAverage($workShiftID)
    {
        $builder = WorkShiftGood::whereHas('good', function ($query) {
            $query->whereIn(GoodsContract::FIELD_TYPE, [1, 2]);
        })->where(WorkShiftGoodsContract::FIELD_WORK_SHIFT_ID, $workShiftID);

        $workShift = WorkShift::find($workShiftID);
        if (!$workShift) {
            return;
        }

        $itemsTotal = 0;
        foreach ($builder->get() as $item) {
            $itemsTotal += $item->{WorkShiftGoodsContract::FIELD_QTY} * $item->{WorkShiftGoodsContract::FIELD_PRICE};
        }

        $visitorsTotal = $workShift->{WorkShiftContract::FIELD_VISITORS_TOTAL};
        if (!$visitorsTotal <= 1) {
            $visitorsTotal = 1;
        }
        $checkAverage = round($itemsTotal / $visitorsTotal, 2);
        WorkShift::where(WorkShiftContract::FIELD_ID, $workShiftID)->update([
            WorkShiftContract::FIELD_CHECK_AVERAGE => $checkAverage,
        ]);
    }
}
