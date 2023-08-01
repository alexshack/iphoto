<?php

namespace App\Models\Structure;

use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
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
}
