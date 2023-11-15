<?php

namespace App\Contracts\WorkShift;

interface WorkShiftPayrollContract {
    public const TABLE = 'work_shift_payrolls';

    public const FIELD_ID = 'id';
    public const FIELD_WORK_SHIFT_ID = 'workshift_id';
    public const FIELD_EMPLOYEE_ID = 'employee_id';
    public const FIELD_CALC_TYPE_ID = 'calc_type_id';
    public const FIELD_WORK_SHIFT_GOOD_ID = 'work_shift_good_id';
    public const FIELD_AMOUNT = 'amount';
    public const FIELD_CUSTOM_DATA = 'custom_data';

    public const CASTS = [
        self::FIELD_CUSTOM_DATA => 'array',
    ];

    public const FILLABLE_FIELDS = [
        self::FIELD_WORK_SHIFT_ID,
        self::FIELD_EMPLOYEE_ID,
        self::FIELD_CALC_TYPE_ID,
        self::FIELD_AMOUNT,
        self::FIELD_WORK_SHIFT_GOOD_ID,
        self::FIELD_CUSTOM_DATA,
    ];

    public const RULES = [
        self::FIELD_WORK_SHIFT_ID => 'required|exists:' . WorkShiftContract::TABLE . ',' . WorkShiftContract::FIELD_ID,
        self::FIELD_EMPLOYEE_ID => 'required',
        self::FIELD_AMOUNT => 'required|numeric',
        self::FIELD_CALC_TYPE_ID => 'required',
        self::FIELD_WORK_SHIFT_GOOD_ID => 'nullable',
        self::FIELD_CUSTOM_DATA => 'nullable',
    ];
}
