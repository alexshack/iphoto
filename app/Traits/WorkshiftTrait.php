<?php

namespace App\Traits;

use App\Contracts\Goods\GoodsContract;
use App\Contracts\Structure\PlaceContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Contracts\WorkShift\WorkShiftGoodsContract;
use App\Models\Goods\Goods;
use App\Models\Structure\Place;
use App\Models\WorkShift\WorkShift;

trait WorkshiftTrait {
    public function createWorkShiftForPlace(Place $place) {
        $workShiftData = [
             WorkShiftContract::FIELD_DATE => date('Y-m-d'),
             WorkShiftContract::FIELD_CITY_ID => $place->{PlaceContract::FIELD_CITY_ID},
             WorkShiftContract::FIELD_PLACE_ID => $place->{PlaceContract::FIELD_ID},
        ];

        $workShift = WorkShift::create($workShiftData);

        $tmcGoods = Goods::where(GoodsContract::FIELD_TYPE, 3)
            ->where(GoodsContract::FIELD_ENTER_READINGS, 1)
            ->get();
        foreach ($tmcGoods as $good) {
            $goodData = [
                WorkShiftGoodsContract::FIELD_WORK_SHIFT_ID => $workShift->{WorkShiftContract::FIELD_ID},
                WorkShiftGoodsContract::FIELD_GOOD_ID => $good->{GoodsContract::FIELD_ID},
            ];
            Goods::create($goodData);
        }
    }
}
