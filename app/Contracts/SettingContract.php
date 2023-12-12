<?php

namespace App\Contracts;

interface SettingContract
{
    public const TABLE = 'settings';
    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_TYPE = 'type';
    public const FIELD_MODEL = 'model';
    public const FIELD_VALUE = 'value';

    public const TYPES_LIST = [
        1 => 'text',
        2 => 'model',
    ];

    public const TYPES_LIST_LABELS = [
        1 => 'Текст',
        2 => 'Выбор значений сущности',
    ];

    public const FILLABLE = [
        self::FIELD_NAME,
        self::FIELD_TYPE,
        self::FIELD_MODEL,
        self::FIELD_VALUE,
    ];

    public const MODELS = [
        'CalcsType' => [
            'label' => 'Тип начислений',
            'class' => 'App\Models\Salary\CalcsType',
        ],
    ];

    public const RULES = [
        'name' => 'required|max:255|min:3',
        'value' => 'nullable',
        'model' => 'nullable',
        'type' => 'required',
    ];

}
