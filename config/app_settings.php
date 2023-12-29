<?php

use App\Contracts\SettingContract;

return [
    'default_settings' => [
        [
            SettingContract::FIELD_TYPE => 2,
            SettingContract::FIELD_NAME => 'salary_10',
            SettingContract::FIELD_MODEL => 'CalcsType',
        ],
        [
            SettingContract::FIELD_TYPE => 2,
            SettingContract::FIELD_NAME => 'salary_25',
            SettingContract::FIELD_MODEL => 'CalcsType',
        ],
        [
            SettingContract::FIELD_TYPE => 2,
            SettingContract::FIELD_NAME => 'last_month_debt',
            SettingContract::FIELD_MODEL => 'CalcsType',
        ],
        [
            SettingContract::FIELD_TYPE => 2,
            SettingContract::FIELD_NAME => 'last_month_debt_place',
            SettingContract::FIELD_MODEL => 'Place',
        ],
    ],
];
