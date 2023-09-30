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
                $relations[] = 'employees.user';
                $relations[] = 'employees.user.personalData:id,user_id,last_name,first_name,middle_name';
            }
        }

        return $goods->with($relations)->get();
    }
}
