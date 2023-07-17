<?php

namespace App\Models;

use App\Contracts\UserPersonalDataContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPersonalData extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = UserPersonalDataContract::TABLE;

    protected $fillable = UserPersonalDataContract::FILLABLE_FIELDS;

    protected $casts = UserPersonalDataContract::CASTS_FIELDS;

    public function setBirthdayAttribute($value)
    {
        if(!empty($value))
            $this->attributes[UserPersonalDataContract::FIELD_BIRTHDAY] = \Carbon\Carbon::createFromFormat('d.m.Y', $value)->format('Y-m-d');
    }
}
