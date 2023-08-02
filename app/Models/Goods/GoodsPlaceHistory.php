<?php

namespace App\Models\Goods;

use App\Contracts\Goods\GoodsPlaceHistoryContract;
use App\Contracts\Structure\PlaceContract;
use App\Models\Structure\Place;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsPlaceHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = GoodsPlaceHistoryContract::TABLE;

    protected $fillable = GoodsPlaceHistoryContract::FILLABLE_FIELDS;

    public function place()
    {
        return $this->belongsTo(Place::class, GoodsPlaceHistoryContract::FIELD_PLACE_ID, PlaceContract::FIELD_ID);
    }
}
