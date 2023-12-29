<?php

namespace App\Contracts\WorkShift;

interface WorkShiftGoodEmployeeContract {

    public const TABLE = 'work_shift_good_employees';

    public const FIELD_ID = 'id';
    public const FIELD_EMPLOYEE_ID = 'employee_id';
    public const FIELD_WORK_SHIFT_GOOD_ID = 'work_shift_good_id';

    public const FILLABLE_FIELDS = [
        self::FIELD_EMPLOYEE_ID,
        self::FIELD_WORK_SHIFT_GOOD_ID,
    ];

    public const RULES  = [
        self::FIELD_EMPLOYEE_ID => 'required',
        self::FIELD_WORK_SHIFT_GOOD_ID => 'required',
    ];

    public const ATTRIBUTES = [
        self::FIELD_EMPLOYEE_ID => 'Сотрудник',
        self::FIELD_WORK_SHIFT_GOOD_ID => 'Товар',
    ];
}
