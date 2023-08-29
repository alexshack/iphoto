<?php

namespace App\Models\WorkShift;

use App\Contracts\Money\SalesTypeContract;
use App\Contracts\WorkShift\WorkShiftFinalCashDeskContract;
use App\Models\Money\SalesType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkShiftFinalCashDesk extends Model
{
    use HasFactory;

    protected $table = WorkShiftFinalCashDeskContract::TABLE;

    protected $fillable = WorkShiftFinalCashDeskContract::FILLABLE_FIELDS;

    public function saleType() {
        return $this->belongsTo(SalesType::class, WorkShiftFinalCashDeskContract::FIELD_SALE_TYPE_ID, SalesTypeContract::FIELD_ID);
    }
}
