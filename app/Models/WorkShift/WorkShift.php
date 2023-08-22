<?php

namespace App\Models\WorkShift;

use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Models\City;
use App\Models\Structure\Place;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkShift extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = WorkShiftContract::TABLE;

    protected $fillable = WorkShiftContract::FILLABLE_FIELDS;

    protected $casts = WorkShiftContract::CASTS;

    public function city() {
        return $this->belongsTo(City::class, WorkShiftContract::FIELD_CITY_ID, CityContract::FIELD_ID);
    }

    public function employees() {
        return $this->hasMany(WorkShiftEmployee::class);
    }

    public function getEmployeesNamesAttribute() {
        return $this->employees->map(function ($item) {
            $personalData = $item->user->getPersonalData();
            return "{$personalData->last_name} {$personalData->first_name}";
        })->implode(', ');
    }

    public function getIsClosableAttribute() {
        $notClosedWorkShiftsCount = WorkShift::where(WorkShiftContract::FIELD_CITY_ID, $this->city_id)
            ->where(WorkShiftContract::FIELD_PLACE_ID, $this->place_id)
            ->where(WorkShiftContract::FIELD_CLOSED, false)
            ->count();
        if ($notClosedWorkShiftsCount > 0) {
            return false;
        }

        return true;
    }

    public function place() {
        return $this->belongsTo(Place::class, WorkShiftContract::FIELD_PLACE_ID, PlaceContract::FIELD_ID);
    }

}
