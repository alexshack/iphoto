<?php

namespace App\Models\Money;

use App\Contracts\Money\ExpenseContract;
use App\Contracts\Money\ExpensesTypeContract;
use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Contracts\UserContract;
use App\Models\City;
use App\Models\Structure\Place;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = ExpenseContract::CASTS;

    protected $table = ExpenseContract::TABLE;

    protected $fillable = ExpenseContract::FILLABLE_FIELDS;

    public function expenseType() {
        return $this->belongsTo(ExpensesType::class, ExpenseContract::FIELD_TYPE_ID, ExpensesTypeContract::FIELD_ID);
    }

    public function city()
    {
        return $this->belongsTo(City::class, ExpenseContract::FIELD_CITY_ID, CityContract::FIELD_ID);
    }

    public function place()
    {
        return $this->belongsTo(Place::class, ExpenseContract::FIELD_PLACE_ID, PlaceContract::FIELD_ID);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, ExpenseContract::FIELD_MANAGER_ID, UserContract::FIELD_ID);
    }
}
