<?php

namespace App\Models;

use App\Contracts\CityContract;
use App\Contracts\UserWorkDataContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserWorkData extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = UserWorkDataContract::TABLE;

    protected $fillable = UserWorkDataContract::FILLABLE_FIELDS;

    protected $casts = UserWorkDataContract::CASTS_FIELDS;

    public function city()
    {
        return $this->hasOne(City::class, CityContract::FIELD_ID, UserWorkDataContract::FIELD_CITY_ID);
    }

    public function setDateOfEmploymentAttribute($value)
    {
        if(!empty($value))
            $this->attributes[UserWorkDataContract::FIELD_DATE_OF_EMPLOYMENT] = \Carbon\Carbon::createFromFormat('d.m.Y', $value)->format('Y-m-d');
    }

    public function setDateOfTerminationAttribute($value)
    {
        if(!empty($value))
            $this->attributes[UserWorkDataContract::FIELD_DATE_OF_TERMINATION] = \Carbon\Carbon::createFromFormat('d.m.Y', $value)->format('Y-m-d');
    }
}
