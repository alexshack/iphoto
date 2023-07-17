<?php

namespace App\Models;

use App\Models\Money\ExpensesType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contracts\UserRoleContract;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = UserRoleContract::TABLE;

    protected $fillable = UserRoleContract::FILLABLE_FIELDS;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function expensesTypes()
    {
        return $this->belongsToMany(ExpensesType::class);
    }
}
