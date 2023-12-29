<?php

namespace App\Models\Money;

use App\Contracts\Money\IncomesTypeContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomesType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = IncomesTypeContract::TABLE;

    protected $fillable = IncomesTypeContract::FILLABLE_FIELDS;
}
