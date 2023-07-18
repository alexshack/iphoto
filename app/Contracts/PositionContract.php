<?php

namespace App\Contracts;

interface PositionContract
{
    public const TABLE = 'positions';
    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_STATUS = 'status';

    public const STATUS_LIST = [
        1 => 'Активен',
        2 => 'Не активен'
    ];

    public const STATUS_CLASS_LIST = [
        1 => 'badge-success',
        2 => 'badge-danger',
    ];

    public const FILLABLE_FIELDS = [
        self::FIELD_NAME,
        self::FIELD_STATUS,
    ];

    public const POSITIONS_LIST = [
        [
            self::FIELD_NAME => 'Фотограф',
            self::FIELD_STATUS => 1,
        ],
        [
            self::FIELD_NAME => 'Продавец',
            self::FIELD_STATUS => 1,
        ],
        [
            self::FIELD_NAME => 'Ассортимент',
            self::FIELD_STATUS => 1,
        ],
        [
            self::FIELD_NAME => 'Ретушер',
            self::FIELD_STATUS => 2,
        ],
    ];
}
