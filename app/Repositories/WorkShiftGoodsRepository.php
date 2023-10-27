<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\Contracts\UserPersonalDataContract;
use App\Contracts\WorkShift\WorkShiftGoodsContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Models\WorkShift\WorkShiftGood;
use App\Models\WorkShift\WorkShift;
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
        $relations = [
            'good'
        ];
        $goods = WorkShiftGood::where(WorkShiftGoodsContract::FIELD_WORK_SHIFT_ID, $workShiftID);
        if ($type) {
            $goods->whereHas('good', function ($query) use ($type) {
                if ($type) {
                    $query->where('type', $type);
                }
                return $query;
            });
            if((int) $type === 1) {
                $relations[] = 'employees';
                $relations[] = 'employees.employee.user';
                $relations[] = 'employees.employee.user.personalData:id,user_id,last_name,first_name,middle_name';
            }
        }

        return $goods->with($relations)->get();
    }

    public function getSalesToDateSum($date) {
        return WorkShiftGood::whereHas('good', function ($query) {
            $query->whereIn('type', [1, 2]);
        })->whereIn(WorkShiftGoodsContract::FIELD_WORK_SHIFT_ID, WorkShift::whereDate(WorkShiftContract::FIELD_DATE, $date)->get(WorkShiftContract::FIELD_ID))
            ->sum(WorkShiftGoodsContract::FIELD_PRICE);
    }

    public function getSalesToMonth($month) {
        return WorkShiftGood::whereHas('good', function ($query) {
            $query->whereIn('type', [1, 2]);
        })
            ->whereMonth('created_at', '=', $month)
            ->sum(WorkShiftGoodsContract::FIELD_PRICE);
    }
}
