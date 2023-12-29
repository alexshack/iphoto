<?php

namespace App\Models\WorkShift;

use App\Contracts\WorkShift\WorkShiftGoodEmployeeContract;
use App\Contracts\WorkShift\WorkShiftEmployeeContract;
use App\Contracts\WorkShift\WorkShiftGoodsContract;
use App\Contracts\Goods\GoodsContract;
use App\Models\Goods\Goods;
use App\Models\WorkShift\WorkShiftEmployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkShiftGood extends Model
{
    use HasFactory;

    protected $fillable = WorkShiftGoodsContract::FILLABLE_FIELDS;
    protected $table = WorkShiftGoodsContract::TABLE;

    public function employee()
    {
        return $this->hasOne(WorkShiftEmployee::class, WorkShiftEmployeeContract::FIELD_ID, WorkShiftGoodsContract::FIELD_EMPLOYEE_ID);
    }

    public function employees() {
        return $this->hasMany(WorkShiftGoodEmployee::class, WorkShiftGoodEmployeeContract::FIELD_WORK_SHIFT_GOOD_ID, WorkShiftGoodsContract::FIELD_ID);
    }

    public function good()
    {
        return $this->belongsTo(Goods::class);
    }

}
