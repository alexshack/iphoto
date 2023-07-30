<?php

namespace App\Models\Structure;

use App\Contracts\Structure\PlaceCalcContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaceCalc extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = PlaceCalcContract::TABLE;

    protected $fillable = PlaceCalcContract::FILLABLE_FIELDS;

    protected $casts = PlaceCalcContract::CASTS;
}
