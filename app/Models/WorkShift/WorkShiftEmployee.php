<?php

namespace App\Models\WorkShift;

use App\Contracts\PositionContract;
use App\Contracts\Salary\EmployeeStatusContract;
use App\Contracts\Salary\PaysContract;
use App\Contracts\Structure\PlaceCalcContract;
use App\Contracts\UserContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Contracts\WorkShift\WorkShiftEmployeeContract;
use App\Contracts\WorkShift\WorkShiftPayrollContract;
use App\Http\Controllers\Money\Workshift\WorkShiftController;
use App\Models\Salary\EmployeeStatuses;
use App\Models\Salary\Pay;
use App\Models\Salary\Position;
use App\Models\Structure\PlaceCalc;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkShiftEmployee extends Model
{
    use HasFactory;

    protected $appends = [
        'salary',
    ];

    protected $table = WorkShiftEmployeeContract::TABLE;

    protected $fillable = WorkShiftEmployeeContract::FILLABLE_FIELDS;

    protected $casts = WorkShiftEmployeeContract::CASTS;

    public function getSalaryDataCompletedAttribute() {
        return app(WorkShiftController::class)->validateEmployeeSalaryData($this);
    }

    public function payrolls() {
        return $this->hasMany(WorkShiftPayroll::class, WorkShiftPayrollContract::FIELD_EMPLOYEE_ID, WorkShiftEmployeeContract::FIELD_ID);
    }

    public function position() {
        return $this->belongsTo(Position::class, WorkShiftEmployeeContract::FIELD_POSITION_ID, PositionContract::FIELD_ID);
    }

    public function getSalaryAttribute() {
        $sum = 0;
        $sum = $this->payrolls->sum(WorkShiftPayrollContract::FIELD_AMOUNT);
        return $sum;
    }

    public function status() {
        return $this->belongsTo(EmployeeStatuses::class, WorkShiftEmployeeContract::FIELD_STATUS, EmployeeStatusContract::FIELD_ID);
    }

    public function user() {
        return $this->belongsTo(User::class, WorkShiftEmployeeContract::FIELD_USER_ID, UserContract::FIELD_ID);
    }

    public function workShift() {
        return $this->belongsTo(WorkShift::class, WorkShiftEmployeeContract::FIELD_WORK_SHIFT_ID, WorkShiftContract::FIELD_ID);
    }
}
