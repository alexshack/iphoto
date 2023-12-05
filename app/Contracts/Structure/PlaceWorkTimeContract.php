<?php

namespace App\Contracts\Structure;

interface PlaceWorkTimeContract
{
    public const TABLE = 'place_work_times';

    public const FIELD_ID = 'id';
    public const FIELD_PLACE_ID = 'place_id';
    public const FIELD_WEEK_DAY = 'week_day';
    public const FIELD_START_TIME = 'start_time';
    public const FIELD_END_TIME = 'end_time';

    public const FILLABLE_FIELDS = [
        self::FIELD_ID,
        self::FIELD_PLACE_ID,
        self::FIELD_WEEK_DAY,
        self::FIELD_START_TIME,
        self::FIELD_END_TIME,
    ];

    public const RULES = [
        self::FIELD_PLACE_ID => 'required',
        self::FIELD_WEEK_DAY => 'required',
    ];

    public const ATTRIBUTES = [
        self::FIELD_PLACE_ID => 'Точка',
        self::FIELD_WEEK_DAY => 'День недели',
        self::FIELD_START_TIME => 'Время начала',
        self::FIELD_END_TIME => 'Время окончания',
    ];

    public const WEEK_DAYS = [
        0 => 'Понедельник',
        1 => 'Вторник',
        2 => 'Среда',
        3 => 'Четверг',
        4 => 'Пятница',
        5 => 'Суббота',
        6 => 'Воскресенье',
    ];

    public const DEFAULT_WORK_TIME_START = '08:00:00';
}
