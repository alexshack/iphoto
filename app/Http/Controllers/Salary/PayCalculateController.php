<?php

namespace App\Http\Controllers\Salary;

use App\Contracts\Salary\CalcsContract;
use App\Contracts\Salary\PaysContract;
use App\Contracts\SettingContract;
use App\Contracts\UserContract;
use App\Contracts\UserWorkDataContract;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CalcsRepositoryInterface;
use App\Repositories\Interfaces\PaysRepositoryInterface;
use App\Repositories\Interfaces\SettingsRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\Salary\Pay;
use App\Models\Salary\Calc;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PayCalculateController extends Controller
{
    protected CalcsRepositoryInterface $calcsRepository;
    protected PaysRepositoryInterface $paysRepository;
    protected SettingsRepositoryInterface $settingRepository;
    protected UserRepositoryInterface $userRepository;

    public function __construct(
        CalcsRepositoryInterface $calcsRepository,
        PaysRepositoryInterface $paysRepository,
        SettingsRepositoryInterface $settingRepository,
        UserRepositoryInterface $userRepository
    )
    {
        $this->calcsRepository = $calcsRepository;
        $this->paysRepository = $paysRepository;
        $this->settingRepository = $settingRepository;
        $this->userRepository = $userRepository;
    }

    public function calculatePayments($month = null, $year = null)
    {
        $now = Carbon::now();
        if (!$month || !$year) {
            $deltaTime = $now->subMonth();
            $month = $deltaTime->month;
            $year = $deltaTime->year;
        }

        if ($month === $now->month && $year === $now->year) {
            return;
        }

        $calcs = [];
        $pays = [];

        $users = $this->userRepository->getAll();

        $salary10 = $this->settingRepository->get('salary_10');
        $salary10Option = $salary10 && $salary10->{SettingContract::FIELD_VALUE} ? $salary10->{SettingContract::FIELD_VALUE} : null;
        $salary25 = $this->settingRepository->get('salary_25');
        $salary25Option = $salary25 && $salary25->{SettingContract::FIELD_VALUE} ? $salary25->{SettingContract::FIELD_VALUE} : null;
        $salaryLastMonthDebt = $this->settingRepository->get('last_month_debt');
        $salaryLastMonthDebtOption = $salaryLastMonthDebt && $salaryLastMonthDebt->{SettingContract::FIELD_VALUE} ? $salaryLastMonthDebt->{SettingContract::FIELD_VALUE} : null;

        $debtPlace = $this->settingRepository->get('last_month_debt_place');
        $debtPlaceID = $debtPlace && $debtPlace->{SettingContract::FIELD_VALUE} ? $debtPlace->{SettingContract::FIELD_VALUE} : 1;

        $date10 = "{$now->year}-{$now->month}-10";
        $date25 = "{$now->year}-{$now->month}-25";
        $billingMonth = "{$year}-{$month}-01";
        $admin = Auth::user();

        if (!$admin) {
            $admin = User::whereHas('role', function ($query) {
                $query->where('slug', 'admin');
            })->first();
        }

        $calcTypesForSalary = [
            $salary10Option => $date10,
            $salary25Option => $date25,
        ];

        foreach ($users as $user) {
            $amount = $this->calculateUsersTotals($user, $month, $year);
            $workData = $user->getWorkData();
            $cityID = $workData->{UserWorkDataContract::FIELD_CITY_ID} ?? 1;
            if ($amount > 0) {
                foreach ($calcTypesForSalary as $calcTypeID => $dateField) {
                    $data = [
                        PaysContract::FIELD_DATE => $dateField,
                        PaysContract::FIELD_BILLING_MONTH => $billingMonth,
                        PaysContract::FIELD_TYPE_ID => $calcTypeID,
                        PaysContract::FIELD_TYPE => 1,
                        PaysContract::FIELD_AGENT_ID => $admin->{UserContract::FIELD_ID},
                        PaysContract::FIELD_CITY_ID => $cityID,
                        PaysContract::FIELD_AMOUNT => $amount / 2,
                        PaysContract::FIELD_SOURCE_ID => $admin->{UserContract::FIELD_ID},
                        PaysContract::FIELD_SOURCE_TYPE => 1,
                        PaysContract::FIELD_USER_ID => $user->{UserContract::FIELD_ID},
                    ];
                    $pays[] = $data;
                }
            } else if ($amount < 0) {
                $data = [
                    PaysContract::FIELD_DATE => $date10,
                    PaysContract::FIELD_BILLING_MONTH => $billingMonth,
                    PaysContract::FIELD_TYPE_ID => $salaryLastMonthDebtOption,
                    PaysContract::FIELD_TYPE => 1,
                    PaysContract::FIELD_AGENT_ID => $admin->{UserContract::FIELD_ID},
                    PaysContract::FIELD_CITY_ID => $cityID,
                    PaysContract::FIELD_AMOUNT => 0,
                    PaysContract::FIELD_SOURCE_ID => $admin->{UserContract::FIELD_ID},
                    PaysContract::FIELD_USER_ID => $user->{UserContract::FIELD_ID},
                    PaysContract::FIELD_SOURCE_TYPE => 1,
                ];
                $pays[] = $data;

                $calcData = [
                    CalcsContract::FIELD_DATE => "{$now->day}.{$now->month}.{$now->year}",
                    CalcsContract::FIELD_TYPE_ID => $salaryLastMonthDebtOption,
                    CalcsContract::FIELD_CITY_ID => $workData->{UserWorkDataContract::FIELD_CITY_ID},
                    CalcsContract::FIELD_USER_ID => $user->{UserContract::FIELD_ID},
                    CalcsContract::FIELD_AGENT_ID => $admin->{UserContract::FIELD_ID},
                    CalcsContract::FIELD_AMOUNT => $amount,
                    CalcsContract::FIELD_TYPE => 5,
                    CalcsContract::FIELD_PLACE_ID => $debtPlaceID,
                ];
                $calcs[] = $calcData;
            }
        }

        foreach ($pays as $payData) {
            Pay::create($payData);
        }

        foreach ($calcs as $calcData) {
            Calc::create($calcData);
        }
    }

    public function calculateUsersTotals($user, $month, $year)
    {
        $calcs = $this->calcsRepository->getByUserID($user->{UserContract::FIELD_ID}, compact('month', 'year'));
        $advancePayments = $this->paysRepository->getAdvancePaymentsForUserAndMonth($user->{UserContract::FIELD_ID}, $month, $year);
        $amount = $calcs['total'] - $advancePayments['total'];
        return $amount;
    }
}
