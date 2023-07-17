<?php

namespace App\Contracts;

interface PositionContract
{
    public const TABLE = 'positions';
    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';

    public const FILLABLE_FIELDS = [
        self::FIELD_NAME,
    ];

    public const POSITIONS_LIST = [
        [
            'name' => 'Фотограф',
        ],
        [
            'name' => 'Продавец',
        ],
    ];
}
