<?php

namespace App\Models\WorkShift;

use App\Contracts\WorkShift\WorkShiftEmployeeContract;
use App\Contracts\WorkShift\WorkShiftGoodEmployeeContract;
use App\Contracts\UserContract;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkShiftGoodEmployee extends Model
{
    use HasFactory;

    protected $table = WorkShiftGoodEmployeeContract::TABLE;

    protected $fillable = WorkShiftGoodEmployeeContract::FILLABLE_FIELDS;

    public function employee() {
        return $this->belongsTo(WorkShiftEmployee::class, WorkShiftGoodEmployeeContract::FIELD_EMPLOYEE_ID, WorkShiftEmployeeContract::FIELD_ID);
    }
}

