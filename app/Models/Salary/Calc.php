<?php

namespace App\Models\Salary;

use App\Contracts\Salary\CalcsContract;
use App\Contracts\Salary\CalcsTypeContract;
use App\Contracts\Salary\PaysContract;
use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Models\City;
use App\Models\Structure\Place;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calc extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = CalcsContract::CASTS;

    protected $fillable = CalcsContract::FILLABLE_FIELDS;

    protected $table = CalsContract::TABLE;

    public function agent()
    {
        return $this->belongsTo(User::class, PaysContract::FIELD_AGENT_ID, UserContract::FIELD_ID);
    }

    public function calcType() {
        return $this->belongsTo(CalcsType::class, PaysContract::FIELD_TYPE_ID, CalcsTypeContract::FIELD_ID);
    }

    public function city()
    {
        return $this->belongsTo(City::class, PaysContract::FIELD_CITY_ID, CityContract::FIELD_ID);
    }

    public function place()
    {
        return $this->belongsTo(Place::class, PaysContract::FIELD_PLACE_ID, PlaceContract::FIELD_ID);
    }

    public function user()
    {
        return $this->belongsTo(User::class, PaysContract::FIELD_USER_ID, UserContract::FIELD_ID);
    }
}
