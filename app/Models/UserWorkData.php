<?php

namespace App\Models;

use App\Contracts\UserWorkDataContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserWorkData extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = UserWorkDataContract::TABLE;

    protected $fillable = UserWorkDataContract::FILLABLE_FIELDS;
}
