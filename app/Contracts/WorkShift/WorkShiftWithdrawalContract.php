<?php

namespace App\Contracts\WorkShift;

interface WorkShiftWithdrawalContract {
    public const TABLE = 'work_shift_withdrawals';

    public const FIELD_ID = 'id';
    public const FIELD_WORK_SHIFT_ID = 'workshift_id';
    public const FIELD_SUM = 'sum';
    public const FIELD_TIME = 'time';

    public const FILLABLE_FIELDS = [
        self::FIELD_WORK_SHIFT_ID,
        self::FIELD_TIME,
        self::FIELD_SUM,
    ];

    public const RULES = [
        self::FIELD_WORK_SHIFT_ID => 'required|exists:' . WorkShiftContract::TABLE . ',' . WorkShiftContract::FIELD_ID,
        self::FIELD_SUM => 'required|numeric',
        self::FIELD_TIME => 'required',
    ];

    public const ATTRIBUTES = [
        self::FIELD_SUM => 'Сумма',
        self::FIELD_TIME => 'Время снятия',
    ];
}
