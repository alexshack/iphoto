<?php

namespace App\Contracts\Goods;

interface GoodsCategoryContract
{
    public const TABLE = 'goods_categories';
    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';

    public const FILLABLE_FIELDS = [
        self::FIELD_NAME
    ];

    public const RULES = [
        self::FIELD_NAME => 'required|string|max:255'
    ];

    public const ATTRIBUTES = [
        self::FIELD_NAME => 'Название'
    ];
}
