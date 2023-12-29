<?php

namespace App\Contracts;

interface UserPersonalDataContract
{
    public const TABLE = 'users_personal_data';
    public const FIELD_ID = 'id';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_LAST_NAME = 'last_name'; // Фамилия
    public const FIELD_FIRST_NAME = 'first_name'; // Имя
    public const FIELD_MIDDLE_NAME = 'middle_name'; // Отчество
    public const FIELD_PHONE = 'phone'; // Телефон
    public const FIELD_PHONE_ADDITIONAL = 'phone_additional'; // Дополнительный телефон
    public const FIELD_BIRTHDAY = 'birthday'; // День рождения
    public const FIELD_GENDER = 'gender'; // Пол
    public const FIELD_MARITAL_STATUS = 'marital_status'; // Семейное положение
    public const FIELD_EDUCATION = 'education'; // Образование
    public const FIELD_EMAIL = 'email'; // E-mail
    public const FIELD_REGISTERED_ADDRESS = 'registered_address'; // Адрес регистрации
    public const FIELD_ADDRESS = 'address'; // Адрес проживания

    public const GENDER_LIST = [
        1 => 'Мужской',
        2 => 'Женский'
    ];

    public const MARITAL_STATUS_LIST = [
        1 => 'Не указано',
        2 => 'Холост/Не замужем',
        3 => 'Женат/Замужем'
    ];

    public const EDUCATION_LIST = [
        1 => 'Не указано',
        2 => 'Среднее',
        3 => 'Средне-специальное',
        4 => 'Высшее неоконченное',
        5 => 'Высшее'
    ];

    public const FILLABLE_FIELDS = [
        self::FIELD_USER_ID,
        self::FIELD_LAST_NAME,
        self::FIELD_FIRST_NAME,
        self::FIELD_MIDDLE_NAME,
        self::FIELD_PHONE,
        self::FIELD_PHONE_ADDITIONAL,
        self::FIELD_BIRTHDAY,
        self::FIELD_GENDER,
        self::FIELD_MARITAL_STATUS,
        self::FIELD_EDUCATION,
        self::FIELD_EMAIL,
        self::FIELD_REGISTERED_ADDRESS,
        self::FIELD_ADDRESS
    ];

    public const CASTS_FIELDS = [
        self::FIELD_BIRTHDAY => 'date'
    ];
}
