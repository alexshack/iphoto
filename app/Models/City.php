<?php

namespace App\Models;

use App\Contracts\CityContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = CityContract::TABLE;

    protected $fillable = CityContract::FILLABLE_FIELDS;
}
