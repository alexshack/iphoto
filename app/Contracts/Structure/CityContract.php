<?php

namespace App\Contracts\Structure;

interface CityContract
{
    public const TABLE = 'cities';
    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_MANAGER_ID = 'manager_id';
    public const FIELD_OPENING_DATE = 'opening_date';

    public const FILLABLE_FIELDS = [
        self::FIELD_NAME,
    ];

    public const CASTS = [
        self::FIELD_OPENING_DATE => 'date'
    ];

    public const DEMO_CITIES_LIST = [
        [
            'name' => 'Белгород',
        ],
        [
            'name' => 'Краснодар',
        ],
    ];
}
