<?php

namespace App\Models\Structure;

use App\Contracts\Salary\CalcsTypeContract;
use App\Contracts\Structure\PlaceCalcContract;
use App\Models\Salary\CalcsType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaceCalc extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = PlaceCalcContract::TABLE;

    protected $fillable = PlaceCalcContract::FILLABLE_FIELDS;

    protected $casts = PlaceCalcContract::CASTS;

    public function calcsType()
    {
        return $this->belongsTo(CalcsType::class, PlaceCalcContract::FIELD_CALCS_TYPE_ID, CalcsTypeContract::FIELD_ID);
    }

    public function getCalcsType()
    {
        $this->calcsType()->get();
    }
}
