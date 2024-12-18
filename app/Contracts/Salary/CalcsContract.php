<?php

namespace App\Contracts\Salary;

use App\Contracts\Salary\CalcsTypeContract;
use App\Contracts\Salary\PaysContract;
use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Contracts\UserContract;

interface CalcsContract {
    public const TABLE = 'calcs';
    public const FIELD_ID = 'id';
    public const FIELD_DATE = 'date';
    public const FIELD_TYPE_ID = 'calcs_type_id';
    public const FIELD_CITY_ID = 'city_id';
    public const FIELD_TYPE = 'type';
    public const FIELD_PLACE_ID = 'place_id';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_AGENT_ID = 'agent_id';
    public const FIELD_AMOUNT = 'amount';
    public const FIELD_NOTE = 'note';

    public const FILLABLE_FIELDS = [
        self::FIELD_DATE,
        self::FIELD_TYPE_ID,
        self::FIELD_CITY_ID,
        self::FIELD_TYPE,
        self::FIELD_PLACE_ID,
        self::FIELD_USER_ID,
        self::FIELD_AGENT_ID,
        self::FIELD_AMOUNT,
        self::FIELD_NOTE,
    ];

    public const CASTS = [
        self::FIELD_DATE => 'date:d.m.Y'
    ];

    public const RULES = [
        self::FIELD_DATE => 'required|date',
        self::FIELD_TYPE_ID => 'required|exists:' . CalcsTypeContract::TABLE . ',' .CalcsTypeContract::FIELD_ID,
        self::FIELD_CITY_ID => 'required|exists:' . CityContract::TABLE . ',' . CityContract::FIELD_ID,
        self::FIELD_PLACE_ID => 'sometimes|nullable|exists:' . PlaceContract::TABLE . ',' . PlaceContract::FIELD_ID,
        self::FIELD_AGENT_ID => 'sometimes|nullable|numeric|exists:' . UserContract::TABLE . ',' . UserContract::FIELD_ID,
        self::FIELD_USER_ID => 'sometimes|nullable|numeric|exists:' . UserContract::TABLE . ',' . UserContract::FIELD_ID,
        self::FIELD_AMOUNT => 'required|numeric',
        self::FIELD_NOTE => 'nullable|string|max:255',
    ];

    public const ATTRIBUTES = [
        self::FIELD_DATE => 'Дата',
        self::FIELD_TYPE_ID => 'Вид начисления',
        self::FIELD_CITY_ID => 'Город',
        self::FIELD_PLACE_ID => 'Точка',
        self::FIELD_USER_ID => 'Сотрудник',
        self::FIELD_AMOUNT => 'Сумма',
        self::FIELD_NOTE => 'Примечания',
    ];
}
