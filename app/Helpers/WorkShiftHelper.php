<?php

namespace App\Helpers;

use App\Contracts\Goods\GoodsContract;
use App\Contracts\Money\ExpenseContract;
use App\Contracts\Money\IncomeContract;
use App\Contracts\Money\MovesContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Contracts\WorkShift\WorkShiftGoodsContract;
use App\Contracts\UserRoleContract;
use App\Models\Money\Expense;
use App\Models\Money\Income;
use App\Models\Money\Move;
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
        $individualGoods = WorkShiftGood::whereHas('good', function ($query) {
            $query->where(GoodsContract::FIELD_TYPE, 2);
        })
            ->where(WorkShiftGoodsContract::FIELD_WORK_SHIFT_ID, $workshift->{WorkShiftContract::FIELD_ID})
            ->get();
        if ($individualGoods->count() > 0) {
            foreach ($individualGoods as $good) {
                $salesIndividual += $good->sum;
            }
        }
        $salesGeneral = 0;
        $generalGoods = WorkShiftGood::whereHas('good', function ($query) {
            $query->where(GoodsContract::FIELD_TYPE, 1);
        })
            ->where(WorkShiftGoodsContract::FIELD_WORK_SHIFT_ID, $workshift->{WorkShiftContract::FIELD_ID})
            ->get();
        if ($generalGoods->count() > 0) {
            foreach ($generalGoods as $good) {
                $salesGeneral += $good->sum;
            }
        }
        $salesTotal = $salesIndividual + $salesGeneral;

        $cashMoney = 0;
        $incomes = Income::where(IncomeContract::FIELD_CITY_ID, $workshift->{WorkShiftContract::FIELD_CITY_ID})
            ->where(IncomeContract::FIELD_PLACE_ID, $workshift->{WorkShiftContract::FIELD_PLACE_ID})
            ->whereDate(IncomeContract::FIELD_DATE, $workshift->{WorkShiftContract::FIELD_DATE})
            ->get();
        if ($incomes->count() > 0) {
            foreach ($incomes as $income) {
                $cashMoney += $income->amount;
            }
        }

        $cashTerminal = 0;

        $cashTotal = $cashMoney + $cashTerminal;

        $expenses = 0;
        $expensesEntries = Expense::where(ExpenseContract::FIELD_CITY_ID, $workshift->{WorkShiftContract::FIELD_CITY_ID})
            ->where(ExpenseContract::FIELD_PLACE_ID, $workshift->{WorkShiftContract::FIELD_PLACE_ID})
            ->whereDate(ExpenseContract::FIELD_DATE, $workshift->{WorkShiftContract::FIELD_DATE})
            ->get();
        foreach ($expensesEntries as $expense) {
            $expenses += $expense->{ExpenseContract::FIELD_AMOUNT};
        }

        $moves = 0;
        $movesEntries = Move::where(MovesContract::FIELD_CITY_ID, $workshift->{WorkShiftContract::FIELD_CITY_ID})
            ->where(MovesContract::FIELD_PAYER_TYPE, 'place')
            ->where(MovesContract::FIELD_PAYER_ID, $workshift->{WorkShiftContract::FIELD_PLACE_ID})
            ->whereDate(MovesContract::FIELD_DATE, $workshift->{WorkShiftContract::FIELD_DATE})
            ->get();
        if ($movesEntries->count() > 0) {
            foreach ($movesEntries as $move) {
                $moves += $move->{MovesContract::FIELD_AMOUNT};
            }
        }

        $prepayments = 0;
        // TODO: выяснить про пометку на выплату зп
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
