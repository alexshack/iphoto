<?php

namespace App\Contracts\Money;

interface ExpensesTypeContract
{
    public const TABLE = 'expenses_types';
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

    public const DEMO_DATA = [
        [
            self::FIELD_NAME => 'Аренда',
            self::FIELD_STATUS => 1
        ],
        [
            self::FIELD_NAME => 'Такси',
            self::FIELD_STATUS => 2
        ]
    ];
}
