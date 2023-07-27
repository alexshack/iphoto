<?php

namespace App\Contracts\Structure;

interface CityManagerContract
{
    public const TABLE = 'cities_manager_history';
    public const FIELD_ID = 'id';
    public const FIELD_CITY_ID = 'city_id';
    public const FIELD_MANAGER_ID = 'manager_id';
    public const FIELD_APPOINTMENT_DATE = 'appointment_date';

    public const FILLABLE_FIELDS = [
        self::FIELD_CITY_ID,
        self::FIELD_MANAGER_ID,
        self::FIELD_APPOINTMENT_DATE,
    ];

    public const CASTS = [
        self::FIELD_APPOINTMENT_DATE => 'date'
    ];
}
