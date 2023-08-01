<?php

namespace App\Models;

use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Contracts\UserContract;
use App\Models\Structure\Place;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = CityContract::TABLE;

    protected $fillable = CityContract::FILLABLE_FIELDS;

    protected $casts = CityContract::CASTS;

    public function user()
    {
        return $this->belongsTo(User::class, CityContract::FIELD_MANAGER_ID, UserContract::FIELD_ID);
    }

    public function getManager()
    {
        return $this->user()->first();
    }

    public function places()
    {
        return $this->hasMany(Place::class, PlaceContract::FIELD_CITY_ID, CityContract::FIELD_ID);
    }
}
