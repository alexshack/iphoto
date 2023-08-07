<?php

namespace App\Models\Money;

use App\Contracts\Money\IncomeContract;
use App\Contracts\Money\IncomesTypeContract;
use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Contracts\UserContract;
use App\Models\City;
use App\Models\Structure\Place;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = IncomeContract::TABLE;

    protected $fillable = IncomeContract::FILLABLE_FIELDS;

    protected $casts = IncomeContract::CASTS;

    public function incomeType()
    {
        return $this->belongsTo(IncomesType::class, IncomeContract::FIELD_TYPE_ID, IncomesTypeContract::FIELD_ID);
    }

    public function city()
    {
        return $this->belongsTo(City::class, IncomeContract::FIELD_CITY_ID, CityContract::FIELD_ID);
    }

    public function place()
    {
        return $this->belongsTo(Place::class, IncomeContract::FIELD_PLACE_ID, PlaceContract::FIELD_ID);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, IncomeContract::FIELD_MANAGER_ID, UserContract::FIELD_ID);
    }
}
