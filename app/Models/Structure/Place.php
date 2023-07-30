<?php

namespace App\Models\Structure;

use App\Contracts\Structure\PlaceContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Place extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = PlaceContract::TABLE;

    protected $fillable = PlaceContract::FILLABLE_FIELDS;

    protected $casts = PlaceContract::CASTS;
}
