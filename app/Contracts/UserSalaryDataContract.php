<?php

namespace App\Contracts;

interface UserSalaryDataContract {
    public const TABLE = 'users_salary_data';

    public const FIELD_ID = 'id';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_CALCS_TYPES_TYPE = 'calcs_types_type';
    public const FIELD_START_DATE = 'start_date';
    public const FIELD_CUSTOM_DATA = 'custom_data';
    public const FIELD_AMOUNT = 'amount';

    public const TYPES_ALLOWED = [
        1, 3, 4,
    ];

    public const FILLABLE = [
        self::FIELD_CALCS_TYPES_TYPE,
        self::FIELD_START_DATE,
        self::FIELD_CUSTOM_DATA,
        self::FIELD_AMOUNT,
        self::FIELD_USER_ID,
    ];

    public const RULES = [
        self::FIELD_CALCS_TYPES_TYPE => 'required',
        self::FIELD_USER_ID => 'required',
        self::FIELD_START_DATE => 'required',
        self::FIELD_CUSTOM_DATA => 'nullable',
        self::FIELD_AMOUNT => 'required|numeric|min:0',
    ];

    public const ATTRIBUTES = [
        self::FIELD_CALCS_TYPES_TYPE => 'Тип расчета',
        self::FIELD_USER_ID => 'Пользователь',
        self::FIELD_START_DATE => 'Дата начала действия расчета',
        self::FIELD_AMOUNT => 'Сумма',
        self::FIELD_CUSTOM_DATA => 'Данные расчетов',
    ];

}
