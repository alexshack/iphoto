<?php

namespace App\Repositories\Interfaces;

interface UserSalaryDataRepositoryInterface {
    public function getActualSalaryData($userID, $calcTypeID);
}
