<?php

namespace App\Models\Salary;

use App\Contracts\Salary\CalcsContract;
use App\Contracts\Salary\CalcsTypeContract;
use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Contracts\UserContract;
use App\Models\City;
use App\Models\Structure\Place;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calc extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = CalcsContract::CASTS;

    protected $fillable = CalcsContract::FILLABLE_FIELDS;

    protected $table = CalcsContract::TABLE;

    public function agent()
    {
        return $this->belongsTo(User::class, CalcsContract::FIELD_AGENT_ID, UserContract::FIELD_ID);
    }

    public function calcType() {
        return $this->belongsTo(CalcsType::class, CalcsContract::FIELD_TYPE_ID, CalcsTypeContract::FIELD_ID);
    }

    public function city()
    {
        return $this->belongsTo(City::class, CalcsContract::FIELD_CITY_ID, CityContract::FIELD_ID);
    }

    public function getIsEditableAttribute() {
        $isEditable = false;
        if ($this->type === 1) {
            $isEditable = true;
        }
        // TODO: payout sync
        return $isEditable;
    }

    public function place()
    {
        return $this->belongsTo(Place::class, CalcsContract::FIELD_PLACE_ID, PlaceContract::FIELD_ID);
    }

    public function scopeFilterData($query, $filterData)
    {
        if (isset($filterData['year']) && $filterData['year']) {
            $query->whereYear(CalcsContract::FIELD_DATE, $filterData['year']);
            if (isset($filterData['month']) && $filterData['month']) {
                $query->whereMonth(CalcsContract::FIELD_DATE, $filterData['month']);
            }
        }

        return $query;
    }

    public function setDateAttribute($value) {
        $this->attributes['date'] = (Carbon::createFromFormat('d.m.Y', $value))->format('Y-m-d');
    }

    public function user()
    {
        return $this->belongsTo(User::class, CalcsContract::FIELD_USER_ID, UserContract::FIELD_ID);
    }
}
