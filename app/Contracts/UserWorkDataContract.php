<?php

namespace App\Contracts;

interface UserWorkDataContract
{
    public const TABLE = 'users_work_data';
    public const FIELD_ID = 'id';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_CITY_ID = 'city_id'; // Город
    public const FIELD_POSITION_ID = 'position_id'; // Должность
    public const FIELD_STATUS = 'status'; // Статус
    public const FIELD_DATE_OF_EMPLOYMENT = 'date_of_employment'; // Дата приема
    public const FIELD_DATE_OF_TERMINATION = 'date_of_termination'; // Дата увольнения

    public const STATUS_LIST = [
        1 => 'Не указан',
        2 => 'Испытательный срок',
        3 => 'Принят на работу',
        4 => 'В отпуске',
        5 => 'Уволен'
    ];

    public const INACTIVE_STATUS_LIST = [1, 4, 5];

    public const STATUS_CLASS_LIST = [
        1 => 'badge-secondary',
        2 => 'badge-info',
        3 => 'badge-success',
        4 => 'badge-warning',
        5 => 'badge-danger',
    ];

    public const FILLABLE_FIELDS = [
        self::FIELD_USER_ID,
        self::FIELD_CITY_ID,
        self::FIELD_POSITION_ID,
        self::FIELD_STATUS,
        self::FIELD_DATE_OF_EMPLOYMENT,
        self::FIELD_DATE_OF_TERMINATION,
        self::FIELD_DATE_OF_TERMINATION
    ];

    public const CASTS_FIELDS = [
        self::FIELD_DATE_OF_EMPLOYMENT => 'date',
        self::FIELD_DATE_OF_TERMINATION => 'date',
    ];
}
