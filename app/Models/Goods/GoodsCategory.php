<?php

namespace App\Models\Goods;

use App\Contracts\Goods\GoodsCategoryContract;
use App\Contracts\Goods\GoodsContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = GoodsCategoryContract::TABLE;

    protected $fillable = GoodsCategoryContract::FILLABLE_FIELDS;

    public function goods()
    {
        return $this->hasMany(Goods::class, GoodsContract::FIELD_CATEGORY_ID, GoodsCategoryContract::FIELD_ID);
    }
}
