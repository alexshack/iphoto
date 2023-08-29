<?php

namespace App\Contracts\WorkShift;

interface WorkShiftFinalCashDeskContract {
    public const TABLE = 'work_shift_final_cash_desks';

    public const FIELD_ID = 'id';
    public const FIELD_SUM = 'sum';
    public const FIELD_WORK_SHIFT_ID = 'workshift_id';
    public const FIELD_SALE_TYPE_ID = 'sale_type_id';

    public const FILLABLE_FIELDS = [
        self::FIELD_WORK_SHIFT_ID,
        self::FIELD_SUM,
        self::FIELD_SALE_TYPE_ID,
    ];

    public const RULES = [
        self::FIELD_WORK_SHIFT_ID => 'required|exists:' . WorkShiftContract::TABLE . ',' . WorkShiftContract::FIELD_ID,
        self::FIELD_SUM => 'required|numeric',
        self::FIELD_SALE_TYPE_ID => 'required',
    ];

    public const ATTRIBUTES = [
        self::FIELD_GOOD_ID => 'Товар',
        self::FIELD_SUM => 'Сумма',
        self::FIELD_SALE_TYPE_ID => 'Вид продажи',
    ];
}
