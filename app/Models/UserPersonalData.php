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
}
