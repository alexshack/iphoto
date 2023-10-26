<?php

namespace App\Models\WorkShift;

use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Contracts\WorkShift\WorkShiftFinalCashDeskContract;
use App\Contracts\WorkShift\WorkShiftGoodsContract;
use App\Contracts\WorkShift\WorkShiftWithdrawalContract;
use App\Contracts\WorkShift\WorkShiftEmployeeContract;
use App\COntracts\UserContract;
use App\Helpers\WorkShiftHelper;
use App\Models\City;
use App\Models\Structure\Place;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkShift extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = WorkShiftContract::TABLE;

    protected $fillable = WorkShiftContract::FILLABLE_FIELDS;

    protected $casts = WorkShiftContract::CASTS;

    protected $statsStorage = [];

    public function goods() {
        return $this->hasMany(WorkShiftGood::class, WorkShiftGoodsContract::FIELD_WORK_SHIFT_ID, WorkShiftContract::FIELD_ID);
    }

    public function city() {
        return $this->belongsTo(City::class, WorkShiftContract::FIELD_CITY_ID, CityContract::FIELD_ID);
    }

    public function closedBy() {
        return $this->belongsTo(User::class, WorkShiftContract::FIELD_CLOSED_BY, UserContract::FIELD_ID);
    }

    public function employees() {
        return $this->hasMany(WorkShiftEmployee::class, WorkShiftEmployeeContract::FIELD_WORK_SHIFT_ID, WorkShiftContract::FIELD_ID);
    }

    public function finalCashDesks() {
        return $this->hasMany(WorkShiftFinalCashDesk::class, WorkShiftFinalCashDeskContract::FIELD_WORK_SHIFT_ID, WorkShiftContract::FIELD_ID);
    }

    public function getEmployeesNamesAttribute() {
        return $this->employees->map(function ($item) {
            $personalData = $item->user->getPersonalData();
            return "{$personalData->last_name} {$personalData->first_name}";
        })->implode(', ');
    }

    public function getIsClosedAttribute() {
        return $this->{WorkShiftContract::FIELD_CLOSED_AT};
    }

    public function getLastWithdrawAttribute() {
        $withdrawals = $this->withdrawals;
        if ($withdrawals->count() > 0) {
            return $withdrawals->last()->{WorkShiftWithdrawalContract::FIELD_TIME};
        }
        return '';
    }

    public function getStatsAttribute() {
        if (!is_array($this->statsStorage) || empty($this->statsStorage)) {
            $this->statsStorage =  WorkShiftHelper::recalculateStats($this);
        }
        return $this->statsStorage['agenda'];
    }

    public function getTitleAttribute() {
        $date = $this->date->format('d.m.Y');
        return "Смена $date - {$this->city->name} - {$this->place->name}";
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

    public function withdrawals() {
        return $this->hasMany(WorkShiftWithdrawal::class, WorkShiftWithdrawalContract::FIELD_WORK_SHIFT_ID, WorkShiftContract::FIELD_ID);
    }
}
