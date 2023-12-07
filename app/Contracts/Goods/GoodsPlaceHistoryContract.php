<?php

namespace App\Contracts\Goods;

use App\Contracts\Structure\PlaceContract;

interface GoodsPlaceHistoryContract
{
    public const TABLE = 'goods_place_histories';
    public const FIELD_ID = 'id';
    public const FIELD_PLACE_ID = 'place_id';
    public const FIELD_GOODS_ID = 'goods_id';
    public const FIELD_NOTE = 'note';

    public const FILLABLE_FIELDS = [
        self::FIELD_PLACE_ID,
        self::FIELD_GOODS_ID,
        self::FIELD_NOTE,
    ];

    public const RULES = [
        self::FIELD_PLACE_ID => 'required|exists:' . PlaceContract::TABLE . ',' . PlaceContract::FIELD_ID,
        self::FIELD_GOODS_ID => 'required|exists:' . GoodsContract::TABLE . ',' . GoodsContract::FIELD_ID,
        self::FIELD_NOTE => 'nullable',
    ];

    public const ATTRIBUTES = [
        self::FIELD_PLACE_ID => 'Точка',
        self::FIELD_GOODS_ID => 'Товар',
        self::FIELD_NOTE => 'Комментарий',
    ];
}
