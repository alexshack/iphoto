<?php

namespace App\Models;

use App\Contracts\Structure\CityManagerContract;
use App\Contracts\UserContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CityManagerHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = CityManagerContract::TABLE;

    protected $fillable = CityManagerContract::FILLABLE_FIELDS;

    protected $casts = CityManagerContract::CASTS;

    public function user()
    {
        return $this->belongsTo(User::class, CityManagerContract::FIELD_MANAGER_ID, UserContract::FIELD_ID);
    }
}
