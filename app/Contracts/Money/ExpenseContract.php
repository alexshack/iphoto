<?php

namespace App\Contracts\Money;

use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Contracts\UserContract;

interface ExpenseContract
{
    public const TABLE = 'expenses';
    public const FIELD_ID = 'id';
    public const FIELD_DATE = 'date';
    public const FIELD_TYPE_ID = 'expense_type_id';
    public const FIELD_CITY_ID = 'city_id';
    public const FIELD_TYPE = 'type';
    public const FIELD_PLACE_ID = 'place_id';
    public const FIELD_MANAGER_ID = 'manager_id';
    public const FIELD_AMOUNT = 'amount';
    public const FIELD_NOTE = 'note';
    public const FIELD_CHECK_FILE = 'check_file';

    public const TYPE_MANAGER = 1;
    public const TYPE_PLACE = 2;

    public const FILLABLE_FIELDS = [
        self::FIELD_DATE,
        self::FIELD_TYPE_ID,
        self::FIELD_CITY_ID,
        self::FIELD_TYPE,
        self::FIELD_PLACE_ID,
        self::FIELD_MANAGER_ID,
        self::FIELD_AMOUNT,
        self::FIELD_NOTE,
        self::FIELD_CHECK_FILE,
    ];

    public const CASTS = [
        self::FIELD_DATE => 'date'
    ];

    public const RULES = [
        self::FIELD_DATE => 'required|date',
        self::FIELD_TYPE_ID => 'required|exists:' . ExpensesTypeContract::TABLE . ',' . ExpensesTypeContract::FIELD_ID,
        self::FIELD_CITY_ID => 'required|exists:' . CityContract::TABLE . ',' . CityContract::FIELD_ID,
        self::FIELD_PLACE_ID => 'sometimes|nullable|exists:' . PlaceContract::TABLE . ',' . PlaceContract::FIELD_ID,
        self::FIELD_MANAGER_ID => 'sometimes|nullable|numeric|exists:' . UserContract::TABLE . ',' . UserContract::FIELD_ID,
        //self::FIELD_TYPE => 'required|numeric|in:1,2',
        self::FIELD_AMOUNT => 'required|numeric',
        self::FIELD_NOTE => 'required|string|max:255',
        self::FIELD_CHECK_FILE => 'nullable',
    ];

    public const ATTRIBUTES = [
        self::FIELD_DATE => 'Дата',
        self::FIELD_TYPE_ID => 'Вид расхода',
        self::FIELD_CITY_ID => 'Город',
        self::FIELD_PAYER_TYPE => 'Выберите тип плательщика',
        self::FIELD_PLACE_ID => 'Точка',
        self::FIELD_MANAGER_ID => 'Менеджер',
        self::FIELD_CHECK_FILE => 'Чек',
        self::FIELD_AMOUNT => 'Сумма',
        self::FIELD_NOTE => 'Примечания',
    ];
}
