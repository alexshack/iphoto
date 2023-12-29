<?php

namespace App\Contracts\Service;

interface ReportContract
{
    public const TABLE = 'reports';

    public const FIELD_ID = 'id';
    public const FIELD_TYPE = 'type';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_COMPLETED_AT = 'completed_at';
    public const FIELD_CUSTOM_DATA = 'custom_data';

    public const CASTS = [
        self::FIELD_CUSTOM_DATA => 'array',
    ];

    public const FILLABLE = [
        self::FIELD_TYPE,
        self::FIELD_USER_ID,
        self::FIELD_COMPLETED_AT,
        self::FIELD_CUSTOM_DATA,
    ];

    public const TYPES = [
        'workshift' => 'Смены',
        'goods' => 'Товары',
    ];
}
