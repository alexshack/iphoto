<?php

namespace App\Models;

use App\Contracts\UserSalaryDataContract;
use App\Contracts\Money\ExpensesTypeContract;
use App\Models\Money\ExpensesType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSalaryData extends Model
{
    use HasFactory;

    protected $fillable = UserSalaryDataContract::FILLABLE;

    protected $table = UserSalaryDataContract::TABLE;

    public function getCustomDataPreviewAttribute() {
        $customData = $this->custom_data;
        $value = '';
        if ($customData) {
            $customData = json_decode($customData);
        } else {
            return $value;
        }
        switch ((int)$this->{UserSalaryDataContract::FIELD_CALCS_TYPES_TYPE}) {
            case 1:
                $types = ExpensesType::whereIn(ExpensesTypeContract::FIELD_ID, $customData)
                    ->get(ExpensesTypeContract::FIELD_NAME);
                if ($types->count() > 0) {
                    $value = $types->map(function ($item) {
                        return $item->{ExpensesTypeContract::FIELD_NAME};
                    })
                        ->implode(', ');
                }
                break;
        }
        return $value;
    }

    public function setStartDateAttribute($value) {
        if ((isset($this->attributes[UserSalaryDataContract::FIELD_START_DATE]) && strpos($this->attributes[UserSalaryDataContract::FIELD_START_DATE], '.') !== false)
        || strpos($value, '.') !== false) {
            $value  = (Carbon::createFromFormat('d.m.Y', $value))->format('Y-m-d');
        }

        $this->attributes[UserSalaryDataContract::FIELD_START_DATE] = $value;
    }
}
