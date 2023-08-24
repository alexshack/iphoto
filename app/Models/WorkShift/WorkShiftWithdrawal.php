<?php

namespace App\Models\WorkShift;

use App\Contracts\WorkShift\WorkShiftWithdrawalContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkShiftWithdrawal extends Model
{
    use HasFactory;

    protected $table = WorkShiftWithdrawalContract::TABLE;

    protected $fillable = WorkShiftWithdrawalContract::FILLABLE_FIELDS;
}
