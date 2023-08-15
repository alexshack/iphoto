<?php

namespace App\Contracts\WorkShift;

use App\Contracts\Goods\GoodsContract;
use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;

interface WorkShiftGoodsContract  {
    public const TABLE = 'work_shift_goods';

    public const FIELD_ID = 'id';
    public const FIELD_WORK_SHIFT_ID = 'workshift_id';
    public const FIELD_EMPLOYEE_ID = 'employee_id';
    public const FIELD_GOOD_ID = 'good_id';
    public const FIELD_QTY = 'qty';
    public const FIELD_PRICE = 'price';

    public const FILLABLE_FIELDS = [
        self::FIELD_WORK_SHIFT_ID,
        self::FIELD_GOOD_ID,
        self::FIELD_QTY,
        self::FIELD_PRICE,
    ];

    public const RULES = [
        self::FIELD_WORK_SHIFT_ID => 'required|exists:' . WorkShiftContract::TABLE . ',' . WorkShiftContract::FIELD_ID,
        self::FIELD_GOOD_ID => 'required|exists:' . GoodsContract::TABLE . ',' . GoodsContract::FIELD_ID,
        self::FIELD_QTY => 'required|numeric|min:0',
        self::FIELD_PRICE => 'required|numeric',
    ];

    public const ATTRIBUTES = [
        self::FIELD_GOOD_ID => 'Товар',
        self::FIELD_QTY => 'КОличество',
        self::FIELD_PRICE => 'Цена',
    ];
}
