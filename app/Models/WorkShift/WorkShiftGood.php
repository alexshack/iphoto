<?php

namespace App\Models\WorkShift;

use App\Contracts\WorkShift\WorkShiftGoodsContract;
use App\Contracts\Goods\GoodsContract;
use App\Models\Goods\Goods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkShiftGood extends Model
{
    use HasFactory;

    protected $fillable = WorkShiftGoodsContract::FILLABLE_FIELDS;
    protected $table = WorkShiftGoodsContract::TABLE;

    public function good()
    {
        return $this->belongsTo(Goods::class);
    }

}
