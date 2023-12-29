<?php

namespace App\Contracts\Goods;

use App\Contracts\Structure\PlaceContract;

interface GoodsContract
{
    public const TABLE = 'goods';
    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_CATEGORY_ID = 'category_id';
    public const FIELD_NOTE = 'note';
    public const FIELD_TYPE = 'type';
    // Поля типа Индивидуальная продажа
    public const FIELD_PRIZE_AMOUNT = 'prize_amount'; // Сумма премии
    public const FIELD_MORE_THAN_ONE = 'more_than_one'; // Больше одного человека
    // Поля типа ТМЦ
    public const FIELD_SERIAL_NUMBER = 'serial_number'; // Серийный номер ТМЦ
    public const FIELD_ENTER_READINGS = 'enter_readings'; // Вводить показания в смене
    public const FIELD_PLACE_ID = 'place_id';
    public const FIELD_COMMENT = 'comment';

    public const DEFAULT_TYPE = 1;

    public const FILLABLE_FIELDS = [
        self::FIELD_NAME,
        self::FIELD_CATEGORY_ID,
        self::FIELD_NOTE,
        self::FIELD_TYPE,
        self::FIELD_PRIZE_AMOUNT,
        self::FIELD_MORE_THAN_ONE,
        self::FIELD_ENTER_READINGS,
        self::FIELD_SERIAL_NUMBER,
        self::FIELD_PLACE_ID,
        self::FIELD_COMMENT,
    ];

    public const TYPE_LIST = [
        1 => 'Продажа',
        2 => 'Индивидуальная продажа',
        3 => 'ТМЦ',
        4 => 'Расходные материалы',
        5 => 'Отработка'
    ];

    public const RULES = [
        self::FIELD_NAME => 'required|string|max:255',
        self::FIELD_CATEGORY_ID => 'required|exists:' . GoodsCategoryContract::TABLE . ',' . GoodsCategoryContract::FIELD_ID,
        self::FIELD_NOTE => 'sometimes|nullable|max:255',
        self::FIELD_TYPE => 'required|numeric|in:1,2,3,4,5',
        self::FIELD_PRIZE_AMOUNT => 'sometimes|nullable|numeric',
        self::FIELD_MORE_THAN_ONE => 'sometimes|nullable',
        self::FIELD_ENTER_READINGS => 'sometimes|nullable',
        self::FIELD_SERIAL_NUMBER => 'sometimes|nullable|string|max:255',
        self::FIELD_PLACE_ID => 'sometimes|nullable|exists:' . PlaceContract::TABLE . ',' . PlaceContract::FIELD_ID,
        self::FIELD_COMMENT => 'sometimes|nullable',
    ];

    public const ATTRIBUTES = [
        self::FIELD_NAME => 'Название',
        self::FIELD_CATEGORY_ID => 'Категория',
        self::FIELD_NOTE => 'Примечание',
        self::FIELD_TYPE => 'Тип товара',
        self::FIELD_PRIZE_AMOUNT => 'Сумма премии',
        self::FIELD_MORE_THAN_ONE => 'Больше одного человека',
        self::FIELD_ENTER_READINGS => 'Вводить показания в смене',
        self::FIELD_SERIAL_NUMBER => 'Серийный номер ТМЦ',
        self::FIELD_PLACE_ID => 'Точка',
        self::FIELD_COMMENT => 'Комментарий',
    ];
}
