<?php

namespace App\Models\WorkShift;

use App\Contracts\UserContract;
use App\Contracts\PositionContract;
use App\Contracts\Salary\EmployeeStatusContract;
use App\Contracts\WorkShift\WorkShiftEmployeeContract;
use App\Models\Salary\EmployeeStatuses;
use App\Models\Salary\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkShiftEmployee extends Model
{
    use HasFactory;

    protected $table = WorkShiftEmployeeContract::TABLE;

    protected $fillable = WorkShiftEmployeeContract::FILLABLE_FIELDS;

    protected $casts = WorkShiftEmployeeContract::CASTS;

    public function position() {
        return $this->belongsTo(Position::class, WorkShiftEmployeeContract::FIELD_POSITION_ID, PositionContract::FIELD_ID);
    }

    public function status() {
        return $this->belongsTo(EmployeeStatuses::class, WorkShiftEmployeeContract::FIELD_STATUS, EmployeeStatusContract::FIELD_ID);
    }

    public function user() {
        return $this->belongsTo(User::class, WorkShiftEmployeeContract::FIELD_USER_ID, UserContract::FIELD_ID);
    }
}
