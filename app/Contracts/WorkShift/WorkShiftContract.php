<?php

namespace App\Contracts\WorkShift;

use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;

interface WorkShiftContract  {
    public const TABLE = 'work_shifts';

    public const FIELD_ID = 'id';
    public const FIELD_DATE = 'date';
    public const FIELD_CITY_ID = 'city_id';
    public const FIELD_PLACE_ID = 'place_id';
    public const FIELD_TOTAL_SALES = 'total_sales';
    public const FIELD_EXPENSES = 'expenses';
    public const FIELD_SALARY = 'salary';
    public const FIELD_CLOSED_AT = 'closed_at';
    public const FIELD_CLOSED_BY = 'closed_by';
    public const FIELD_START_TIME = 'start_time';
    public const FIELD_VISITORS_TOTAL = 'visitors_total';
    public const FIELD_CHECK_AVERAGE = 'check_average';

    public const FILLABLE_FIELDS = [
        self::FIELD_DATE,
        self::FIELD_CITY_ID,
        self::FIELD_PLACE_ID,
        self::FIELD_START_TIME,
        self::FIELD_VISITORS_TOTAL,
        self::FIELD_CHECK_AVERAGE,
    ];

    public const CASTS = [
        self::FIELD_DATE => 'date:d.m.Y',
    ];

    public const RULES = [
        self::FIELD_DATE => 'required|date',
        self::FIELD_CITY_ID => 'required|exists:' . CityContract::TABLE . ',' . CityContract::FIELD_ID,
        self::FIELD_PLACE_ID => 'sometimes|nullable|exists:' . PlaceContract::TABLE . ',' . PlaceContract::FIELD_ID,
    ];

    public const ATTRIBUTES = [
        self::FIELD_DATE => 'Дата',
        self::FIELD_CITY_ID => 'Город',
        self::FIELD_PLACE_ID => 'Точка',
        self::FIELD_TOTAL_SALES => 'Касса',
        self::FIELD_EXPENSES => 'Расходы',
        self::FIELD_SALARY => 'Зарплата',
        self::FIELD_START_TIME => 'Начало смены',
        self::FIELD_CHECK_AVERAGE => 'Средний чек',
    ];

    public const AGENDA_ERRORS = [
        'cash_sums_not_equal' => 'Не совпадают суммы продаж и кассы',
        'fcd_empty' => 'Не заполнены данные по оборудованию',
        'previous_workshift_not_closed' => 'Предыдущая смена не закрыта',
        'withdrawal_not_numeric' => 'Не заполнены суммы снятия кассы',
    ];

    public const USER_INPUT_FIELDS = [
        self::FIELD_CHECK_AVERAGE => [
            'type' => 'number',
        ],
    ];
}
