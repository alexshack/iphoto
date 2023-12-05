<?php

namespace App\Models\Structure;

use App\Contracts\Structure\PlaceWorkTimeContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceWorkTime extends Model
{
    use HasFactory;

    protected $appends = [
        'week_day_name',
    ];

    protected $table = PlaceWorkTimeContract::TABLE;

    protected $fillable = PlaceWorkTimeContract::FILLABLE_FIELDS;

    public function getWeekDayNameAttribute()
    {
        return PlaceWorkTimeContract::WEEK_DAYS[$this->{PlaceWorkTimeContract::FIELD_WEEK_DAY}];
    }
}
