<?php

namespace App\Contracts\Structure;

interface PlaceContract
{
    public const TABLE = 'places';
    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_CITY_ID = 'city_id';
    public const FIELD_OPENING_DATE = 'opening_date';
    public const FIELD_CURRENT_BALANCE = 'current_balance'; // Текущий баланс
    public const FIELD_STATUS = 'status';

    public const STATUS_LIST = [
        1 => 'Работает',
        2 => 'Закрыта временно',
        3 => 'Закрыта'
    ];

    public const STATUS_CLASS_LIST = [
        1 => 'badge-success',
        2 => 'badge-warning',
        3 => 'badge-danger',
    ];

    public const DEFAULT_STATUS = 1;

    public const FILLABLE_FIELDS = [
        self::FIELD_NAME,
        self::FIELD_CITY_ID,
        self::FIELD_OPENING_DATE,
        self::FIELD_STATUS,
    ];

    public const CASTS = [
        self::FIELD_OPENING_DATE => 'date'
    ];

    public const RULES = [
        self::FIELD_NAME => 'required|string|max:255',
        self::FIELD_STATUS => 'required|numeric|in:1,2,3',
        self::FIELD_CITY_ID => 'required|exists:' . CityContract::TABLE . ',' . CityContract::FIELD_ID,
        self::FIELD_OPENING_DATE => 'sometimes|date'
    ];

    public const ATTRIBUTES = [
        self::FIELD_NAME => 'Название точки',
        self::FIELD_STATUS => 'Статус',
        self::FIELD_CITY_ID => 'Город',
        self::FIELD_OPENING_DATE => 'Дата открытия',
    ];

    public const DEMO_DATA = [
        [
            self::FIELD_NAME => 'Аквапарк',
        ],
        [
            self::FIELD_NAME => 'Динопарк',
        ],
        [
            self::FIELD_NAME => 'Парк развлечений'
        ]
    ];
}
