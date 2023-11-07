<?php

namespace App\Repositories;

use App\Contracts\UserSalaryDataContract;
use App\Models\UserSalaryData;
use App\Repositories\Interfaces\UserSalaryDataRepositoryInterface;
use Carbon\Carbon;

class UserSalaryDataRepository implements UserSalaryDataRepositoryInterface {

    public function getActualSalaryData($userID, $calcTypeID)
    {
        if (!in_array($calcTypeID, UserSalaryDataContract::TYPES_ALLOWED)) {
            return null;
        }

        $now = Carbon::now();
        $builder = UserSalaryData::where(UserSalaryDataContract::FIELD_START_DATE, '<=', $now->format('Y-m-d'))
            ->where(UserSalaryDataContract::FIELD_USER_ID, $userID)
            ->where(UserSalaryDataContract::FIELD_CALCS_TYPES_TYPE, $calcTypeID)
            ->orderBy(UserSalaryDataContract::FIELD_START_DATE, 'desc');
        return $builder->first();
    }

}
