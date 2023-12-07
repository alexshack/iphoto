<?php

namespace App\Contracts\WorkShift;

interface WorkShiftVisitorContract {
    public const TABLE = 'work_shift_visitors';

    public const FIELD_ID = 'id';
    public const FIELD_TYPE = 'type';
    public const FIELD_TOTAL = 'total';
    public const FIELD_WORK_SHIFT_ID = 'work_shift_id';

    public const FILLABLE = [
        self::FIELD_TOTAL,
        self::FIELD_TYPE,
        self::FIELD_WORK_SHIFT_ID,
    ];

    public const TYPES = [
        1 => 'Люди',
        2 => 'Чеки',
        3 => 'Столы',
    ];
}
