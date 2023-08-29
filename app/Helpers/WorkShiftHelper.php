<?php

namespace App\Helpers;

use App\Contracts\UserRoleContract;
use App\Models\WorkShift\WorkShift;
use App\Models\WorkShift\WorkShiftGood;
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

        $salesIndividual = 0;
        $salesGeneral = 0;
        $salesTotal = $salesIndividual + $salesGeneral;

        $cashMoney = 0;
        $cashTerminal = 0;
        $cashTotal = $cashMoney + $cashTerminal;
        $expenses = 0;
        $moves = 0;
        $prepayments = 0;
        $expensesTotal = $expenses + $moves + $prepayments;
        $cashBalance = 0;
        $payroll = 0;

        $agenda = compact(
            'cashBalance',
            'cashMoney',
            'cashTerminal',
            'cashTotal',
            'expenses',
            'moves',
            'payroll',
            'prepayments',
            'salesGeneral',
            'salesIndividual',
            'salesTotal',
            'withdrawal'
        );

        return compact('agenda', 'errors');
    }
}
