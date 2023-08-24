<?php

namespace App\Helpers;

use App\Contracts\UserRoleContract;
use App\Models\WorkShift\WorkShift;
use App\Models\WorkShift\WorkShiftWithdrawal;
use Auth;

class WorkShiftHelper {



    public static function recalculateStats(WorkShift $workshift) {
        $errors = [];
        $withdrawal = 0;
        $lastWithdrawal = $workshift->withdrawals->last();
        if ($lastWithdrawal) {
            $withdrawal = $lastWithdrawal->sum;
        }

        $salesTotal = 0;
        $salesIndividual = 0;

        $agenda = compact(
            'salesIndividual',
            'salesTotal',
            'withdrawal'
        );

        return compact('agenda', 'errors');
    }
}
