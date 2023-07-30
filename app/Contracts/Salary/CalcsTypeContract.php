<?php

namespace App\Contracts\Salary;

use App\Contracts\PositionContract;

interface CalcsTypeContract
{
    public const TABLE = 'calcs_types';
    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_AUTOMATIC_CALCULATION = 'automatic_calculation';
    public const FIELD_SALARY_PAYMENT = 'salary_payment';
    public const FIELD_TYPE = 'type';
    public const FIELD_CUSTOM_DATA = 'custom_data'; // Кастомные поля в каждой категории в json
    public const FIELD_STATUS = 'status';

    public const DEFAULT_STATUS = 1;
    public const DEFAULT_TYPE = 1;

    public const STATUS_LIST = [
        1 => 'Активен',
        2 => 'Не активен'
    ];

    public const STATUS_CLASS_LIST = [
        1 => 'badge-success',
        2 => 'badge-danger',
    ];

    public const TYPE_LIST = [
        1 => [
            'name' => 'Процент от кассы',
            'fields' => [
                [
                    'attribute' => 'Должности',
                    'name' => 'positions',
                    'validation_field' => 'custom_data.positions.*',
                    'rules' => 'required|int|exists:' . PositionContract::TABLE . ',' . PositionContract::FIELD_ID
                ],
                [
                    'attribute' => 'Процент, если один сотрудник',
                    'name' => 'percent_for_one',
                    'validation_field' => 'custom_data.percent_for_one',
                    'rules' => 'required|numeric|max:100'
                ],
                [
                    'attribute' => 'Процент, если больше одного',
                    'name' => 'percent_for_multiple',
                    'validation_field' => 'custom_data.percent_for_multiple',
                    'rules' => 'required|numeric|max:100'
                ]
            ]
        ],
        2 => [
            'name' => 'Продажа товара',
            'fields' => []
        ],
        3 => [
            'name' => 'Оклад',
            'fields' => [
                [
                    'attribute' => 'Статусы',
                    'name' => 'employee_statuses',
                    'validation_field' => 'custom_data.employee_statuses.*',
                    'rules' => 'required|int|exists:' . EmployeeStatusContract::TABLE . ',' . EmployeeStatusContract::FIELD_ID,
                ],
                [
                    'attribute' => 'Процент от оклада',
                    'name' => 'salary_percent',
                    'validation_field' => 'custom_data.salary_percent',
                    'rules' => 'required|numeric|max:100',
                ]
            ]
        ],
        4 => [
            'name' => 'Фиксированная смена',
            'fields' => [
                [
                    'attribute' => 'Должности',
                    'name' => 'positions',
                    'validation_field' => 'custom_data.positions.*',
                    'rules' => 'required|int|exists:' . PositionContract::TABLE . ',' . PositionContract::FIELD_ID
                ],
                [
                    'attribute' => 'Количество часов за смену',
                    'name' => 'hours_count',
                    'validation_field' => 'custom_data.hours_count',
                    'rules' => 'required|numeric|max:24',
                ]
            ]
        ],
        5 => [
            'name' => 'Ввод вручную',
            'fields' => [
                [
                    'attribute' => 'Должности',
                    'name' => 'positions',
                    'validation_field' => 'custom_data.positions.*',
                    'rules' => 'required|int|exists:' . PositionContract::TABLE . ',' . PositionContract::FIELD_ID
                ]
            ]
        ],
    ];

    public const FILTER_TYPE_LIST = [
        1 => 'Должность',
        2 => '-',
        3 => 'Статус',
        4 => 'Должность',
        5 => 'Должность',
    ];

    public const FILLABLE_FIELDS = [
        self::FIELD_NAME,
        self::FIELD_AUTOMATIC_CALCULATION,
        self::FIELD_SALARY_PAYMENT,
        self::FIELD_TYPE,
        self::FIELD_CUSTOM_DATA,
        self::FIELD_STATUS,
    ];
}
