<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\Contracts\UserPersonalDataContract;
use App\Contracts\WorkShift\WorkShiftGoodsContract;
use App\Models\WorkShift\WorkShiftGood;
use App\Repositories\Interfaces\WorkShiftGoodsRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class WorkShiftGoodsRepository implements WorkShiftGoodsRepositoryInterface
{

    public function find($id) {
        return WorkShiftGood::find($id);
    }

    /**
     * @return Collection
     */
    public function getAll($workShiftID, $type = null): Collection
    {
        $goods = WorkShiftGood::where(WorkShiftGoodsContract::FIELD_WORK_SHIFT_ID, $workShiftID)
            ->with([
                'good'
            ]);
        if ($type) {
            $goods->whereHas('good', function ($query) use ($type) {
                if ($type) {
                    $query->where('type', $type);
                }
                return $query;
            });
        }
        return $goods->get();
    }
}
