<?php

namespace App\Helpers;

use App\Contracts\Goods\GoodsContract;
use App\Contracts\Money\ExpenseContract;
use App\Contracts\Money\IncomeContract;
use App\Contracts\Money\MovesContract;
use App\Contracts\Money\SalesTypeContract;
use App\Contracts\Salary\PaysContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Contracts\WorkShift\WorkShiftFinalCashDeskContract;
use App\Contracts\WorkShift\WorkShiftGoodsContract;
use App\Contracts\UserRoleContract;
use App\Models\Money\Expense;
use App\Models\Money\Income;
use App\Models\Money\Move;
use App\Models\Money\SalesType;
use App\Models\Salary\Pay;
use App\Models\WorkShift\WorkShift;
use App\Models\WorkShift\WorkShiftFinalCashDesk;
use App\Models\WorkShift\WorkShiftGood;
use App\Models\WorkShift\WorkShiftWithdrawal;
use Auth;

class WorkShiftHelper {
    public static function recalculateStats(WorkShift $workshift) {
        $access = [
            'closable' => false,
            'cancelable' => false,
        ];

        $errors = [];

        $withdrawal = 0;
        $lastWithdrawal = $workshift->withdrawals->last();
        if ($lastWithdrawal) {
            $withdrawal = $lastWithdrawal->sum;
        }

        $withdrawals = $workshift->withdrawals;
        foreach ($withdrawals as $withdrawalItem) {
            if (!is_numeric($withdrawalItem->sum)) {
                $access['closable'] = false;
                $errors[] = WorkShiftContract::AGENDA_ERRORS['withdrawal_not_numeric'];
            }
        }

        $salesIndividual = 0;
        $individualGoods = WorkShiftGood::whereHas('good', function ($query) {
            $query->where(GoodsContract::FIELD_TYPE, 2);
        })
            ->where(WorkShiftGoodsContract::FIELD_WORK_SHIFT_ID, $workshift->{WorkShiftContract::FIELD_ID})
            ->get();
        if ($individualGoods->count() > 0) {
            foreach ($individualGoods as $good) {
                $amount = $good->{WorkShiftGoodsContract::FIELD_PRICE} * $good->{WorkShiftGoodsContract::FIELD_QTY};
                $salesIndividual += $amount;
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
                $salesGeneral += $good->{WorkShiftGoodsContract::FIELD_PRICE} * $good->{WorkShiftGoodsContract::FIELD_QTY};
            }
        }
        $salesTotal = $salesIndividual + $salesGeneral;

        $tmcGoods = WorkShiftGood::whereHas('good', function ($query) {
            $query->where(GoodsContract::FIELD_TYPE, 3);
        })
            ->where(WorkShiftGoodsContract::FIELD_WORK_SHIFT_ID, $workshift->{WorkShiftContract::FIELD_ID})
            ->get();
        if ($tmcGoods->count() > 0) {
            foreach ($tmcGoods as $good) {
                if (!is_numeric($good->{WorkShiftGoodsContract::FIELD_ON_START}) || !is_numeric($good->{WorkShiftGoodsContract::FIELD_ON_END})) {
                    $access['closable'] = false;
                    $errors[] = WorkShiftContract::AGENDA_ERRORS['fcd_empty'];
                    break;
                }
            }
        }

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
        $prepaymentsEntities = Pay::where(PaysContract::FIELD_TYPE, 2)
            ->where(PaysContract::FIELD_DATE, $workshift->{WorkShiftContract::FIELD_DATE})
            ->where(PaysContract::FIELD_CITY_ID, $workshift->{WorkShiftContract::FIELD_CITY_ID})
            ->where(PaysContract::FIELD_SOURCE_TYPE, 2)
            ->where(PaysContract::FIELD_SOURCE_ID, $workshift->{WorkShiftContract::FIELD_PLACE_ID})
            ->get();

        if ($prepaymentsEntities->count() > 0) {
            foreach ($prepaymentsEntities as $prepayment) {
                $prepayments += $prepayment->{PaysContract::FIELD_AMOUNT};
            }
        }

        $expensesTotal = $expenses + $moves + $prepayments;

        $cashTerminal = 0;

        $cashBox = [
            'amount' => 0,
            'children' => [],
        ];
        $saleTypes = SalesType::where(SalesTypeContract::FIELD_STATUS, 1)->get();
        foreach ($saleTypes as $saleType) {
            $saleTypeData = [
                'label' => $saleType->{SalesTypeContract::FIELD_NAME},
                'amount' => 0,
            ];

            $fcds = WorkShiftFinalCashDesk::whereHas('saleType', function ($q) use ($saleType) {
                $q->where(SalesTypeContract::FIELD_RECIPIENT, $saleType->{SalesTypeContract::FIELD_RECIPIENT});
            })
                ->where(WorkShiftFinalCashDeskContract::FIELD_WORK_SHIFT_ID, $workshift->{WorkShiftContract::FIELD_ID})
                ->get();

            foreach ($fcds as $fcd) {
                $saleTypeData['amount'] += (float) $fcd->{WorkShiftFinalCashDeskContract::FIELD_SUM};
            }

            $cashBox['amount'] += $saleTypeData['amount'];

            $cashBox['children'][] = $saleTypeData;
        }

        if ($withdrawal != $salesTotal) {
            $access['closable'] = false;
            $errors[] = WorkShiftContract::AGENDA_ERRORS['cash_sums_not_equal'];
        }

        $payroll = 0;

        $agenda = compact(
            'cashBox',
            'expensesTotal',
            'expenses',
            'moves',
            'payroll',
            'prepayments',
            'salesGeneral',
            'salesIndividual',
            'salesTotal',
            'withdrawal'
        );

        $user = Auth::user();
        $isEmployee = $workshift->employees->first(function ($employee) use ($user) {
            if ($user) {
                return $employee->user_id = $user->id;
            }
        });

        $nextWorkShift = WorkShift::where(WorkShiftContract::FIELD_PLACE_ID, $workshift->{WorkShiftContract::FIELD_PLACE_ID})
            ->where(WorkShiftContract::FIELD_CITY_ID, $workshift->{WorkShiftContract::FIELD_CITY_ID})
            ->whereDate(WorkShiftContract::FIELD_DATE, '>', $workshift->{WorkShiftContract::FIELD_DATE})
            ->orderBy(WorkShiftContract::FIELD_ID, 'desc')
            ->first();

        if ($workshift->isClosed &&
            ($user->role->{UserRoleContract::FIELD_SLUG} === UserRoleContract::ADMIN_SLUG || $isEmployee) &&
            ($nextWorkshift && !$nextWorkshift->isClosed)
            ) {
            $cancelable = true;
        }

        $previousWorkShift = WorkShift::where(WorkShiftContract::FIELD_PLACE_ID, $workshift->{WorkShiftContract::FIELD_PLACE_ID})
            ->where(WorkShiftContract::FIELD_CITY_ID, $workshift->{WorkShiftContract::FIELD_CITY_ID})
            ->whereDate(WorkShiftContract::FIELD_DATE, '<', $workshift->{WorkShiftContract::FIELD_DATE})
            ->orderBy(WorkShiftContract::FIELD_ID, 'desc')
            ->first();

        if ($previousWorkShift->isClosed) {
            $access['closable'] = false;
            $errors[] = WorkShiftContract::AGENDA_ERRORS['previous_workshift_not_closed'];
        }

        return compact('agenda', 'access', 'errors');
    }
}
