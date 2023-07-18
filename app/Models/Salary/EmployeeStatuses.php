<?php

namespace App\Models\Salary;

use App\Contracts\Salary\EmployeeStatusContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeStatuses extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = EmployeeStatusContract::TABLE;

    protected $fillable = EmployeeStatusContract::FILLABLE_FIELDS;
}
