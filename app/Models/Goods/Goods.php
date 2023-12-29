<?php

namespace App\Models\Goods;

use App\Contracts\Goods\GoodsContract;
use App\Contracts\Goods\GoodsPlaceHistoryContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = GoodsContract::TABLE;

    protected $fillable = GoodsContract::FILLABLE_FIELDS;

    public function category()
    {
        return $this->belongsTo(GoodsCategory::class);
    }

    protected static function boot()
    {
        static::created(function($goods) {
            if(!empty($goods->{ GoodsContract::FIELD_PLACE_ID })) {
                GoodsPlaceHistory::create([
                    GoodsPlaceHistoryContract::FIELD_PLACE_ID => $goods->{ GoodsContract::FIELD_PLACE_ID },
                    GoodsPlaceHistoryContract::FIELD_GOODS_ID => $goods->{ GoodsContract::FIELD_ID }
                ]);
            }
        });
        parent::boot();
    }

    public function addHistory()
    {
        if(!empty($this->{ GoodsContract::FIELD_PLACE_ID })) {
            GoodsPlaceHistory::create([
                GoodsPlaceHistoryContract::FIELD_PLACE_ID => $this->{ GoodsContract::FIELD_PLACE_ID },
                GoodsPlaceHistoryContract::FIELD_GOODS_ID => $this->{ GoodsContract::FIELD_ID },
                GoodsPlaceHistoryContract::FIELD_NOTE => $this->{ GoodsContract::FIELD_NOTE },
            ]);
            $this->{ GoodsContract::FIELD_NOTE } = '';
            $this->saveQuietly();
        }
    }

    public function getTypeName()
    {
       return GoodsContract::TYPE_LIST[ $this->{ GoodsContract::FIELD_TYPE } ] ?? null;
    }
}
