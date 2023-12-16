<?php

namespace App\Models\Salary;

use App\Contracts\Salary\CalcsContract;
use App\Contracts\Salary\CalcsTypeContract;
use App\Contracts\Salary\PaysContract;
use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Contracts\UserContract;
use App\Helpers\Helper;
use App\Models\City;
use App\Models\Structure\Place;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pay extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = PaysContract::CASTS;

    protected $table = PaysContract::TABLE;

    protected $fillable = PaysContract::FILLABLE_FIELDS;

    public function agent()
    {
        return $this->belongsTo(User::class, PaysContract::FIELD_AGENT_ID, UserContract::FIELD_ID);
    }

    public function calcType() {
        return $this->belongsTo(CalcsType::class, PaysContract::FIELD_TYPE_ID, CalcsContract::FIELD_ID);
    }

    public function city()
    {
        return $this->belongsTo(City::class, PaysContract::FIELD_CITY_ID, CityContract::FIELD_ID);
    }

    public function getBillingMonthHumanAttribute() {
        $date = $this->billing_month;
        $dateArr = explode('-', $date);
        if (count($dateArr) < 3) {
            return $this->billing_month;
        }

        $month = Helper::getMonthName((int)$dateArr[1]);
        return "{$month} {$dateArr[0]}";
    }

    //public function getDateAttribute() {
        //return $this->attributes[PaysContract::FIELD_DATE]->format('d.m.Y');
    //}

    public function getIsEditableAttribute() {
        $isEditable = false;
        if (!$this->{PaysContract::FIELD_ISSUED}) {
            $isEditable = true;
        }
        return $isEditable;
    }


    public function scopeFilterData($query, $filterData)
    {
        if (isset($filterData['year']) && $filterData['year']) {
            $query->whereYear(PaysContract::FIELD_DATE, $filterData['year']);
            if (isset($filterData['month']) && $filterData['month']) {
                $query->whereMonth(PaysContract::FIELD_DATE, $filterData['month']);
            }
        }

        if (isset($filterData['billing_year']) && $filterData['billing_year']) {
            $query->whereYear(PaysContract::FIELD_BILLING_MONTH, $filterData['billing_year']);
            if (isset($filterData['billing_month']) && $filterData['billing_month']) {
                $query->whereMonth(PaysContract::FIELD_BILLING_MONTH, $filterData['billing_month']);
            }
        }

        if (isset($filterData['issued'])) {
            $query->where(PaysContract::FIELD_ISSUED, (boolean) $filterData['issued']);
        }

        if (isset($filterData['type'])) {
            $query->where(PaysContract::FIELD_TYPE, $filterData['type']);
        }

        if (isset($filterData['calcType']) && $filterData['calcType']) {
            $query->where(PaysContract::FIELD_TYPE_ID, $filterData['calcType']);
        }

        return $query;
    }
    public function setDateAttribute($value) {
        if (strpos($value, '.') !== false) {
            $this->attributes['date'] = (Carbon::createFromFormat('d.m.Y', $value))->format('Y-m-d');
        } else {
            $this->attributes['date'] = $value;
        }
    }

    public function source() {
        $className = null;
        $externalID = null;
        switch ($this->{PaysContract::FIELD_SOURCE_TYPE}) {
        case PaysContract::SOURCE_TYPES['manager']:
            $className = User::class;
            $externalID = UserContract::FIELD_ID;
            break;
        case PaysContract::SOURCE_TYPES['place']:
            $className = Place::class;
            $externalID = PlaceContract::FIELD_ID;
            break;
        }

        return $this->belongsTo($className, PaysContract::FIELD_SOURCE_ID, $externalID);
    }

    public function user()
    {
        return $this->belongsTo(User::class, PaysContract::FIELD_USER_ID, UserContract::FIELD_ID);
    }
}
