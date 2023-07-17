<?php

namespace App\Models\Money;

use App\Contracts\Money\ExpensesTypeContract;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpensesType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = ExpensesTypeContract::TABLE;

    protected $fillable = ExpensesTypeContract::FILLABLE_FIELDS;

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
