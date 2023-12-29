<?php

namespace App\Models\Salary;

use App\Contracts\PositionContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = PositionContract::TABLE;

    protected $fillable = PositionContract::FILLABLE_FIELDS;
}
