<?php

namespace App\Contracts\Service;

interface PaysGeneratorContract
{
    public const TABLE = 'pays_generator';
    public const FIELD_ID = 'id';
    public const FIELD_MONTH = 'month';
    public const FIELD_YEAR = 'year';
    public const FIELD_COMPLETED_AT = 'completed_at';
    public const FIELD_USER_ID = 'user_id';

    public const FILLABLE = [
        self::FIELD_MONTH,
        self::FIELD_YEAR,
        self::FIELD_COMPLETED_AT,
        self::FIELD_USER_ID,
    ];
}
