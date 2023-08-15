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

    public function place()
    {
        return $this->belongsTo(Place::class, PaysContract::FIELD_PLACE_ID, PlaceContract::FIELD_ID);
    }

    public function user()
    {
        return $this->belongsTo(User::class, PaysContract::FIELD_USER_ID, UserContract::FIELD_ID);
    }
}
