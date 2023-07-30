<?php

namespace App\Contracts\Structure;

interface PlaceCalcContract
{
    public const TABLE = 'place_calcs';
    public const FIELD_ID = 'id';
    public const FIELD_PLACE_ID = 'place_id';
    public const FIELD_CALCS_TYPE_ID = 'calcs_type_id';
    public const FIELD_START_DATE = 'start_date';
    public const FIELD_END_DATE = 'end_date';

    public const FILLABLE_FIELDS = [
        self::FIELD_PLACE_ID,
        self::FIELD_CALCS_TYPE_ID,
        self::FIELD_START_DATE,
        self::FIELD_END_DATE
    ];

    public const CASTS = [
        self::FIELD_START_DATE => 'date',
        self::FIELD_END_DATE => 'date'
    ];
}
