<?php

namespace App\Models\Salary;

use App\Contracts\PositionContract;
use App\Contracts\Salary\CalcsTypeContract;
use App\Contracts\Salary\EmployeeStatusContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalcsType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = CalcsTypeContract::TABLE;

    protected $fillable = CalcsTypeContract::FILLABLE_FIELDS;

    protected $custom;

    public function getCustom()
    {
        if(!$this->custom) {
            $this->custom = json_decode($this->{ CalcsTypeContract::FIELD_CUSTOM_DATA });
        }
        return $this->custom;
    }

    public function getTypeName()
    {
        return CalcsTypeContract::TYPE_LIST[$this->{ CalcsTypeContract::FIELD_TYPE }]['name'] ?? null;
    }

    public function getFilterType()
    {
        return CalcsTypeContract::FILTER_TYPE_LIST[ $this->{ CalcsTypeContract::FIELD_TYPE } ] ?? null;
    }

    public function getFilter()
    {
        $result = '-';
        if(in_array($this->{CalcsTypeContract::FIELD_TYPE}, [1, 4, 5], true)) {
            $result = Position::whereIn(PositionContract::FIELD_ID, $this->getCustom()->positions)->get()->pluck(PositionContract::FIELD_NAME)->implode(', ');
        }
        if($this->{CalcsTypeContract::FIELD_TYPE} == 3) {
            $result = EmployeeStatuses::whereIn(EmployeeStatusContract::FIELD_ID, $this->getCustom()->employee_statuses)->get()->pluck(EmployeeStatusContract::FIELD_NAME)->implode(', ');
        }

        return $result;
    }
}
