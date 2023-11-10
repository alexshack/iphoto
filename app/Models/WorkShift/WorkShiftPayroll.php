<?php

namespace App\Models\WorkShift;

use App\Contracts\WorkShift\WorkShiftEmployeeContract;
use App\Contracts\WorkShift\WorkShiftPayrollContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkShiftPayroll extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = WorkShiftPayrollContract::TABLE;

    protected $fillable = WorkShiftPayrollContract::FILLABLE_FIELDS;

    public function employee() {
        return $this->belongsTo(WorkShiftEmployee::class, WorkShiftPayrollContract::FIELD_EMPLOYEE_ID, WorkShiftEmployeeContract::FIELD_ID);
    }
}
