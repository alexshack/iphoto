<?php

namespace App\Models\WorkShift;

use App\Contracts\WorkShift\WorkShiftVisitorContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkShiftVisitor extends Model
{
    use HasFactory;

    protected $appends = [
        'type_name',
    ];

    protected $table = WorkShiftVisitorContract::TABLE;

    protected $fillable = WorkShiftVisitorContract::FILLABLE;

    public function getTypeNameAttribute() {
        $name = '';
        if (isset(WorkShiftVisitorContract::TYPES[$this->{WorkShiftVisitorContract::FIELD_TYPE}])) {
            $name = WorkShiftVisitorContract::TYPES[$this->{WorkShiftVisitorContract::FIELD_TYPE}];
        }
        return $name;
    }
}
