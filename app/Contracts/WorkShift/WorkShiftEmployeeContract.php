<?php

namespace App\Contracts\WorkShift;

use App\Contracts\UserContract;

interface WorkShiftEmployeeContract {
    public const TABLE = 'work_shift_employees';

    public const FIELD_ID = 'id';
    public const FIELD_WORK_SHIFT_ID = 'workshift_id';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_STATUS = 'status_id';
    public const FIELD_POSITION_ID = 'position_id';
    public const FIELD_START_TIME = 'start_time';
    public const FIELD_END_TIME = 'end_time';
    public const FIELD_WORK_TIME = 'work_time';

    public const FILLABLE_FIELDS = [
        self::FIELD_WORK_SHIFT_ID,
        self::FIELD_USER_ID,
        self::FIELD_STATUS,
        self::FIELD_POSITION_ID,
        self::FIELD_START_TIME,
        self::FIELD_END_TIME,
        self::FIELD_WORK_TIME,
    ];

    public const CASTS = [
    ];

    public const RULES = [
        self::FIELD_WORK_SHIFT_ID => 'required|exists:' . WorkShiftContract::TABLE . ',' . WorkShiftContract::FIELD_ID,
        self::FIELD_USER_ID => 'sometimes|nullable|numeric|exists:' . UserContract::TABLE . ',' . UserContract::FIELD_ID,
        self::FIELD_STATUS => 'required',
        self::FIELD_START_TIME => 'required',
        self::FIELD_END_TIME => 'nullable',
        self::FIELD_POSITION_ID => 'required',
    ];

    public const ATTRIBUTES = [
        self::FIELD_USER_ID => 'Сотрудник',
        self::FIELD_STATUS => 'Статус',
        self::FIELD_POSITION_ID => 'Должность на смене',
        self::FIELD_START_TIME => 'Время прихода',
        self::FIELD_END_TIME => 'Время ухода',
    ];
}
