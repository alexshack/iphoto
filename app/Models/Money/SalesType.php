<?php

namespace App\Models\Money;

use App\Contracts\Money\SalesTypeContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = SalesTypeContract::TABLE;

    protected $fillable = SalesTypeContract::FILLABLE_FIELDS;
}
