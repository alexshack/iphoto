<?php

namespace App\Models\Structure;

use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceCalcContract;
use App\Contracts\Structure\PlaceContract;
use App\Contracts\Structure\PlaceWorkTimeContract;
use App\Models\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Place extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = PlaceContract::TABLE;

    protected $fillable = PlaceContract::FILLABLE_FIELDS;

    protected $casts = PlaceContract::CASTS;

    protected $manager;

    public function city()
    {
        return $this->belongsTo(City::class, PlaceContract::FIELD_CITY_ID, CityContract::FIELD_ID);
    }

    public function placeCalcs() {
        return $this->hasMany(PlaceCalc::class, PlaceCalcContract::FIELD_PLACE_ID, PlaceContract::FIELD_ID);
    }

    public function getPlaceWorkTimesAttribute() {
        $workTimesArr = [];
        $workTimes = $this->getWorkTimes();
        if ($workTimes->count() < 7) {
            foreach (PlaceWorkTimeContract::WEEK_DAYS as $weekDayNum => $weekDay) {
                $weekDayPass = $workTimes->filter(function ($item) use ($weekDayNum) {
                    return $item->{PlaceWorkTimeContract::FIELD_WEEK_DAY} === $weekDayNum;
                });
                if ($weekDayPass->count() === 1) {
                    continue;
                } else if ($weekDayPass->count() === 0) {
                    $data = [
                        PlaceWorkTimeContract::FIELD_PLACE_ID => $this->{PlaceContract::FIELD_ID},
                        PlaceWorkTimeContract::FIELD_WEEK_DAY => $weekDayNum,
                        PlaceWorkTimeContract::FIELD_START_TIME => PlaceWorkTimeContract::DEFAULT_WORK_TIME_START,
                    ];
                    PlaceWorkTime::create($data);
                }
            }
            $workTimes = $this->getWorkTimes();
        }

        foreach ($workTimes as $workTime) {
            $workTimesArr[$workTime->{PlaceWorkTimeContract::FIELD_WEEK_DAY}] = [
                PlaceWorkTimeContract::FIELD_ID => $workTime->{PlaceWorkTimeContract::FIELD_ID},
                'weekDayName' => $workTime->week_day_name,
                PlaceWorkTimeContract::FIELD_START_TIME => $workTime->{PlaceWorkTimeContract::FIELD_START_TIME},
                PlaceWorkTimeContract::FIELD_END_TIME => $workTime->{PlaceWorkTimeContract::FIELD_END_TIME},
            ];
        }
        return $workTimesArr;
    }

    protected function getWorkTimes()
    {
        return PlaceWorkTime::where(PlaceWorkTimeContract::FIELD_PLACE_ID, $this->{PlaceContract::FIELD_ID})
            ->orderBy(PlaceWorkTimeContract::FIELD_WEEK_DAY, 'asc')
            ->get();
    }
}
