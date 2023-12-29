<?php

namespace App\Contracts\Money;

use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Contracts\UserContract;

interface MovesContract
{
    public const TABLE = 'moves';
    public const FIELD_ID = 'id';
    public const FIELD_DATE = 'date';
    public const FIELD_PAYER_TYPE = 'payer_type';
    public const FIELD_PAYER_ID = 'payer_id';
    public const FIELD_RECIPIENT_TYPE = 'recipient_type';
    public const FIELD_RECIPIENT_ID = 'recipient_id';
    public const FIELD_CITY_ID = 'city_id';
    //public const FIELD_TYPE = 'type';
    public const FIELD_AMOUNT = 'amount';
    public const FIELD_NOTE = 'note';

    public const FILLABLE_FIELDS = [
        self::FIELD_DATE,
        self::FIELD_PAYER_TYPE,
        self::FIELD_PAYER_ID,
        self::FIELD_RECIPIENT_ID,
        self::FIELD_RECIPIENT_TYPE,
        self::FIELD_CITY_ID,
        //self::FIELD_TYPE,
        self::FIELD_AMOUNT,
        self::FIELD_NOTE,
    ];

    public const CASTS = [
        self::FIELD_DATE => 'date:d.m.Y'
    ];

    public const RULES = [
        self::FIELD_DATE => 'required|date',
        self::FIELD_CITY_ID => 'required|exists:' . CityContract::TABLE . ',' . CityContract::FIELD_ID,
        self::FIELD_PAYER_TYPE => 'required',
        self::FIELD_PAYER_ID => 'required|numeric',
        self::FIELD_RECIPIENT_TYPE => 'required',
        self::FIELD_RECIPIENT_ID => 'required',
        self::FIELD_AMOUNT => 'required|numeric',
        self::FIELD_NOTE => 'nullable|string|max:255',
    ];

    public const ATTRIBUTES = [
        self::FIELD_DATE => 'Дата',
        self::FIELD_CITY_ID => 'Город',
        self::FIELD_PAYER_TYPE => 'Тип плательщика',
        self::FIELD_PAYER_ID => 'Плательщик',
        self::FIELD_RECIPIENT_TYPE => 'Тип получателя',
        self::FIELD_RECIPIENT_ID => 'Получатель',
        self::FIELD_AMOUNT => 'Сумма',
        self::FIELD_NOTE => 'Примечания',
    ];
}
