<?php

namespace App\Contracts;

interface CityContract
{
    public const TABLE = 'cities';
    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';

    public const FILLABLE_FIELDS = [
        self::FIELD_NAME,
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
