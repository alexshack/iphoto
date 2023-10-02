<?php

namespace App\Repositories;

use App\Contracts\Salary\PaysContract;
use App\Contracts\UserContract;
use App\Contracts\UserPersonalDataContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Models\Salary\Pay;
use App\Models\WorkShift\WorkShift;
use App\Repositories\Interfaces\PaysRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PaysRepository implements PaysRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Pay::all();
    }

    public function find($id) {
        return Pay::find($id);
    }

    public function getByFilter($data): Collection {
        return Pay::whereYear(PaysContract::FIELD_DATE, $data['year'])
            ->whereMonth(PaysContract::FIELD_DATE, $data['month'])
            ->get();
    }

    public function getByWorkshift(WorkShift $workShift, $type = null) {
        $pays = Pay::where(PaysContract::FIELD_DATE, $workShift->{WorkShiftContract::FIELD_DATE})
            ->where(PaysContract::FIELD_SOURCE_TYPE, 2)
            ->where(PaysContract::FIELD_SOURCE_ID, $workShift->{WorkShiftContract::FIELD_PLACE_ID})
            ->where(PaysContract::FIELD_CITY_ID, $workShift->{WorkShiftContract::FIELD_CITY_ID});

        if ($type) {
            $pays = $pays->where(PaysContract::FIELD_TYPE, $type);
        }
        $pays = $pays->with(
            'user',
            'user.personalData:'. UserContract::FIELD_ID . ',' . UserPersonalDataContract::FIELD_USER_ID . ',' . UserPersonalDataContract::FIELD_LAST_NAME . ',' .UserPersonalDataContract::FIELD_FIRST_NAME . ',' .UserPersonalDataContract::FIELD_MIDDLE_NAME,
        );
        return $pays->get();
    }
}
