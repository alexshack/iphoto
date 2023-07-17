<?php

namespace App\Contracts\Money;

interface SalesTypeContract
{
    public const TABLE = 'sales_types';
    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_RECIPIENT = 'recipient';
    public const FIELD_VALUE = 'value'; // Дополнительные расходы, % (для статистики)
    public const FIELD_STATUS = 'status';

    public const STATUS_LIST = [
        1 => 'Активен',
        2 => 'Не активен'
    ];

    public const STATUS_CLASS_LIST = [
        1 => 'badge-success',
        2 => 'badge-danger',
    ];

    public const RECIPIENT_LIST = [
        1 => 'Точка',
        2 => 'Менеджер',
        3 => 'Бухгалтерия',
    ];

    public const FILLABLE_FIELDS = [
        self::FIELD_NAME,
        self::FIELD_RECIPIENT,
        self::FIELD_VALUE,
        self::FIELD_STATUS,
    ];

    public const DEMO_DATA = [
        [
            self::FIELD_NAME => 'Наличные',
            self::FIELD_RECIPIENT => 1,
            self::FIELD_VALUE => 0,
            self::FIELD_STATUS => 1
        ],
        [
            self::FIELD_NAME => 'Безналичные',
            self::FIELD_RECIPIENT => 3,
            self::FIELD_VALUE => 0.8,
            self::FIELD_STATUS => 2
        ]
    ];
}
