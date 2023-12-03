<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Contracts\Goods\GoodsContract;
use App\Contracts\Salary\CalcsContract;
use App\Contracts\Salary\CalcsTypeContract;
use App\Contracts\Structure\PlaceCalcContract;
use App\Contracts\UserContract;
use App\Contracts\UserSalaryDataContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Contracts\WorkShift\WorkShiftEmployeeContract;
use App\Contracts\WorkShift\WorkShiftGoodEmployeeContract;
use App\Contracts\WorkShift\WorkShiftGoodsContract;
use App\Contracts\WorkShift\WorkShiftPayrollContract;
use App\Contracts\WorkShift\WorkShiftWithdrawalContract;
use App\Helpers\Helper;
use App\Helpers\WorkShiftHelper;
use App\Http\Controllers\Controller;
use App\Models\Salary\Calc;
use App\Models\User;
use App\Models\WorkShift\WorkShift;
use App\Models\WorkShift\WorkShiftEmployee;
use App\Models\WorkShift\WorkShiftPayroll;
use App\Repositories\Interfaces\CalcsRepositoryInterface;
use App\Repositories\Interfaces\CalcsTypeRepositoryInterface;
use App\Repositories\Interfaces\PlaceCalcRepositoryInterface;
use App\Repositories\Interfaces\UserSalaryDataRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftEmployeeRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftGoodsRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftPayrollRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftWithdrawalRepositoryInterface;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkShiftController extends Controller
{
    private CalcsRepositoryInterface $calcsRepository;
    private CalcsTypeRepositoryInterface $calcsTypeRepository;
    private PlaceCalcRepositoryInterface $placeCalcsRepository;
    private UserSalaryDataRepositoryInterface $userSalaryDataRepository;
    private WorkShiftEmployeeRepositoryInterface $workShiftEmployeeRepository;
    private WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository;
    private WorkShiftPayrollRepositoryInterface $workShiftPayrollRepository;
    private WorkShiftRepositoryInterface $workShiftRepo;
    private WorkShiftWithdrawalRepositoryInterface $workShiftWithdrawalRepository;

    public function __construct(CalcsRepositoryInterface $calcsRepository,
        CalcsTypeRepositoryInterface $calcsTypeRepository,
        PlaceCalcRepositoryInterface $placeCalcsRepository,
        UserSalaryDataRepositoryInterface $userSalaryDataRepository,
        WorkShiftRepositoryInterface $workShiftRepo,
        WorkShiftEmployeeRepositoryInterface $workShiftEmployeeRepository,
        WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository,
        WorkShiftPayrollRepositoryInterface $workShiftPayrollRepository,
        WorkShiftWithdrawalRepositoryInterface $workShiftWithdrawalRepository) {
        $this->calcsRepository = $calcsRepository;
        $this->calcsTypeRepository = $calcsTypeRepository;
        $this->placeCalcsRepository = $placeCalcsRepository;
        $this->userSalaryDataRepository = $userSalaryDataRepository;
        $this->workShiftGoodsRepository = $workShiftGoodsRepository;
        $this->workShiftRepo = $workShiftRepo;
        $this->workShiftEmloyeeRepository = $workShiftEmployeeRepository;
        $this->workShiftWithdrawalRepository = $workShiftWithdrawalRepository;
        $this->workShiftPayrollRepository = $workShiftPayrollRepository;
    }

    protected function calculatePayrolls(WorkShift $workShift) {
        $payRolls = [];

        $placeCalcs = $this->placeCalcsRepository->getActiveByPlaceId($workShift->{WorkShiftContract::FIELD_PLACE_ID});
        $employees = $this->workShiftEmloyeeRepository->getAll($workShift->{WorkShiftContract::FIELD_ID});
        $hasTypeCalculated = [
            "type.2" => false,
            "type.3" => false,
            "type.4" => false,
        ];
        foreach ($placeCalcs as $placeCalc) {
            $calcType = $placeCalc->calcsType;
            switch ($calcType->{CalcsTypeContract::FIELD_TYPE}) {
            case 1:
                $this->handlePercentCalcType($workShift, $calcType, $payRolls, $employees);
                break;
            case 2:
                $this->handleGeneralSaleCalcType($workShift, $calcType, $payRolls, $employees);
                $hasTypeCalculated["type.2"] = true;
                break;
            case 3:
                $this->handleSalaryCalcType($workShift, $calcType, $payRolls, $employees);
                $hasTypeCalculated["type.3"] = true;
                break;
            case 4:
                $this->handleFixSalaryCalcType($workShift, $calcType, $payRolls, $employees);
                $hasTypeCalculated["type.4"] = true;
                break;
            default:
                break;
            }
        }

        $individualSaleCalcType = $placeCalcs->filter(function ($item) {
            return $item->{CalcsTypeContract::FIELD_TYPE} === 2;
        })->first();
        if (!$individualSaleCalcType) {
            $individualSaleCalcType = $this->calcsTypeRepository->getByTypeLast(2);
        }
        $this->handleIndividualSaleCalcType($workShift, $individualSaleCalcType, $payRolls, $employees);

        if (!$hasTypeCalculated['type.3']) {
            $calcType = $this->calcsTypeRepository->getByTypeLast(3);
            if ($calcType) {
                $this->handleSalaryCalcType($workShift, $calcType, $payRolls, $employees);
            }
        }

        if (!$hasTypeCalculated['type.4']) {
            $calcType = $this->calcsTypeRepository->getByTypeLast(4);
            if ($calcType) {
                $this->handleSalaryCalcType($workShift, $calcType, $payRolls, $employees);
            }
        }

        return $payRolls;
    }

    public function close(Request $request) {
        $workShift = $this->workShiftRepo->find($request->get('id'));

        $stats = WorkShiftHelper::recalculateStats($workShift);

        // close action
        $this->closeAction($workShift);

        $stats = WorkShiftHelper::recalculateStats($workShift);

        return response()->json([
            'data' => $workShift->id,
            'agenda' => $stats['agenda'],
        ]);
    }

    public function closeAction(WorkShift $workShift, $stats = []) {
        if (empty($stats)) {
            $stats = WorkShiftHelper::recalculateStats($workShift);
        }

        $this->savePayrolls($workShift);

        $calcs = [];
        $workShiftPayrolls = $this->workShiftPayrollRepository->getByWorkShiftID($workShift->{WorkShiftContract::FIELD_ID});
        $user = Auth::user();
        if (!$user) {
            $user = User::find(1);
        }
        $userID = $user->{UserContract::FIELD_ID};

        $existingCalcs = $this->calcsRepository->getByWorkShift($workShift);
        foreach ($existingCalcs as $calc) {
            $calc->delete();
        }

        foreach ($workShiftPayrolls as $payRoll) {
            $employee = $payRoll->employee;
            if (!$employee) {
                continue;
            }
            $data = [
                CalcsContract::FIELD_DATE => $workShift->{WorkShiftContract::FIELD_DATE}->format('d.m.Y'),
                CalcsContract::FIELD_TYPE_ID => $payRoll->{WorkShiftPayrollContract::FIELD_CALC_TYPE_ID},
                CalcsContract::FIELD_CITY_ID => $workShift->{WorkShiftContract::FIELD_CITY_ID},
                CalcsContract::FIELD_PLACE_ID => $workShift->{WorkShiftContract::FIELD_PLACE_ID},
                CalcsContract::FIELD_TYPE => 1,
                CalcsContract::FIELD_USER_ID => $payRoll->employee->{WorkShiftEmployeeContract::FIELD_USER_ID},
                CalcsContract::FIELD_AGENT_ID => $userID,
                CalcsContract::FIELD_AMOUNT => $payRoll->{WorkShiftPayrollContract::FIELD_AMOUNT}
            ];
            Calc::create($data);
        }

        $workShift->{WorkShiftContract::FIELD_CLOSED_AT} = Carbon::now();
        $workShift->save();
        if ($stats['access']['closable']) {
        }
    }

    protected function handleFixSalaryCalcType(WorkShift $workShift, $calcType, &$payRolls, $employees)
    {
        $custom = $calcType->getCustom();
        $employeePositions = [];
        if (isset($custom->positions)) {
            $employeePositions = $custom->positions;
        }

        $calcTypeEmployees = $employees->filter(function ($employee) use ($employeePositions) {
            return in_array($employee->{WorkShiftEmployeeContract::FIELD_POSITION_ID}, $employeePositions);
        });

        foreach ($calcTypeEmployees as $employee) {
            $userID = $employee->{WorkShiftEmployeeContract::FIELD_USER_ID};
            $calcTypeID = $calcType->{CalcsTypeContract::FIELD_TYPE};
            $salaryData = $this->userSalaryDataRepository
                ->getActualSalaryData($userID, $calcTypeID);
            if (!$salaryData) {
                \Log::info('No salary data => ' . $userID);
                continue;
            }

            $salaryAmount = $salaryData->{UserSalaryDataContract::FIELD_AMOUNT};
            $data = [
                WorkShiftPayrollContract::FIELD_WORK_SHIFT_ID => $workShift->{WorkShiftContract::FIELD_ID},
                WorkShiftPayrollContract::FIELD_EMPLOYEE_ID => $employee->{WorkShiftEmployeeContract::FIELD_ID},
                WorkShiftPayrollContract::FIELD_AMOUNT => $salaryAmount,
                WorkShiftPayrollContract::FIELD_CALC_TYPE_ID => $calcType->{CalcsTypeContract::FIELD_ID},
                //WorkShiftPayrollContract::FIELD_CALC_TYPE_ID => 4,
            ];
            $payRolls[] = $data;
        }
    }

    protected function handleSalaryCalcType(WorkShift $workShift, $calcType, &$payRolls, $employees)
    {
        $employeeStatuses = [];
        $custom = $calcType->getCustom();
        if (isset($custom->employee_statuses)) {
            $employeeStatuses = $custom->employee_statuses;
        }

        $calcTypeEmployees = $employees->filter(function ($employee) use ($employeeStatuses) {
            return in_array($employee->{WorkShiftEmployeeContract::FIELD_STATUS}, $employeeStatuses);
        });

        foreach ($calcTypeEmployees as $employee) {
            $userID = $employee->{WorkShiftEmployeeContract::FIELD_USER_ID};
            $calcTypeID = $calcType->{CalcsTypeContract::FIELD_TYPE};
            $salaryData = $this->userSalaryDataRepository
                ->getActualSalaryData($userID, $calcTypeID);
            if (!$salaryData) {
                continue;
            }

            $workTime = $employee->{WorkShiftEmployeeContract::FIELD_WORK_TIME};
            $salaryAmount = $salaryData->{UserSalaryDataContract::FIELD_AMOUNT};
            $amount = $workTime * $salaryAmount / 60;

            $data = [
                WorkShiftPayrollContract::FIELD_WORK_SHIFT_ID => $workShift->{WorkShiftContract::FIELD_ID},
                WorkShiftPayrollContract::FIELD_EMPLOYEE_ID => $employee->{WorkShiftEmployeeContract::FIELD_ID},
                WorkShiftPayrollContract::FIELD_AMOUNT => $amount,
                WorkShiftPayrollContract::FIELD_CALC_TYPE_ID => $calcType->{CalcsTypeContract::FIELD_ID},
                //WorkShiftPayrollContract::FIELD_CALC_TYPE_ID => 3,
            ];
            $payRolls[] = $data;
        }
    }

    protected function handleIndividualSaleCalcType(WorkShift $workShift, $calcType, &$payRolls, $employees) {
        $individualSales = $this->workShiftGoodsRepository->getAll($workShift->{WorkShiftContract::FIELD_ID}, 2);
        foreach ($individualSales as $sale) {
            $amount = $sale->good->{GoodsContract::FIELD_PRIZE_AMOUNT} * $sale->{WorkShiftGoodsContract::FIELD_QTY};
            $data = [
                WorkShiftPayrollContract::FIELD_WORK_SHIFT_ID => $workShift->{WorkShiftContract::FIELD_ID},
                WorkShiftPayrollContract::FIELD_EMPLOYEE_ID => $sale->employee->{WorkShiftEmployeeContract::FIELD_ID},
                WorkShiftPayrollContract::FIELD_AMOUNT => $amount,
                WorkShiftPayrollContract::FIELD_CALC_TYPE_ID => $calcType->{CalcsTypeContract::FIELD_ID},
                WorkShiftPayrollContract::FIELD_WORK_SHIFT_GOOD_ID => $sale->{WorkShiftGoodsContract::FIELD_ID},
            ];
            $payRolls[] = $data;
        }
    }

    protected function handlePercentCalcType(WorkShift $workShift, $calcType, &$payRolls, $employees) {
        $positions = [];
        $custom = $calcType->getCustom();
        if (isset($custom->positions)) {
            $positions = $custom->positions;
        }

        $calcTypeEmployees = $employees->filter(function ($employee) use ($positions) {
            return in_array($employee->{WorkShiftEmployeeContract::FIELD_POSITION_ID}, $positions);
        });

        $withdrawals = $this->workShiftWithdrawalRepository->getByWorkShiftWithWorkTimeSort($workShift->{WorkShiftContract::FIELD_ID});
        //foreach ($withdrawals as $key => $withdrawal) {
            //dump("[$key] {$withdrawal->{WorkShiftWithdrawalContract::FIELD_TIME}}");
        //}
        //exit;

        if ($withdrawals->count() <= 1) {
            return;
        }

        $placeWorkStartTimeC = Carbon::parse('08:00:00');
        $midnight = Carbon::parse('00:00:00');
        $endOfDay = Carbon::parse('23:59:59');
        $workShiftEmployees = $employees->map(function ($item) use ($endOfDay, $midnight, $placeWorkStartTimeC) {
            $startTimeC = Carbon::parse($item->{WorkShiftEmployeeContract::FIELD_START_TIME});
            $endTimeC = Carbon::parse($item->{WorkShiftEmployeeContract::FIELD_END_TIME});

            $startTimeStamp = 0;
            if ($startTimeC->greaterThanOrEqualTo($placeWorkStartTimeC)) {
                $startTimeStamp = $placeWorkStartTimeC->diffInMinutes($startTimeC);
            } else if ($startTimeC->greaterThanOrEqualTo($midnight) && $startTimeC->lessThan($placeWorkStartTimeC)) {
                $startTimeStamp = $placeWorkStartTimeC->diffInMinutes($endOfDay);
                $startTimeStamp += $midnight->diffInMinutes($startTimeC) + 1;
            }

            $endTimeStamp = 0;
            if ($endTimeC->greaterThanOrEqualTo($placeWorkStartTimeC)) {
                $endTimeStamp = $placeWorkStartTimeC->diffInMinutes($endTimeC);
            } else if ($endTimeC->greaterThanOrEqualTo($midnight) && $endTimeC->lessThan($placeWorkStartTimeC)) {
                $endTimeStamp = $placeWorkStartTimeC->diffInMinutes($endOfDay);
                $endTimeStamp += $midnight->diffInMinutes($endTimeC) + 1;
            }

            return [
                WorkShiftEmployeeContract::FIELD_ID => $item->{WorkShiftEmployeeContract::FIELD_ID},
                'startTimeStamp' => $startTimeStamp,
                'endTimeStamp' => $endTimeStamp,
            ];
        });
        //dump($workShiftEmployees);

        for ($i = 1; $i < $withdrawals->count(); $i++) {
            //dump($i);
            $startTime = $withdrawals[$i - 1]->{WorkShiftWithdrawalContract::FIELD_TIME};
            $endTime = $withdrawals[$i]->{WorkShiftWithdrawalContract::FIELD_TIME};

            $startTimestamp = Helper::timeToTimestamp(Carbon::parse($startTime), $placeWorkStartTimeC);
            $endTimestamp = Helper::timeToTimestamp(Carbon::parse($endTime), $placeWorkStartTimeC);

            $startSum = (float) $withdrawals[$i - 1]->{WorkShiftWithdrawalContract::FIELD_SUM};
            $endSum = (float) $withdrawals[$i]->{WorkShiftWithdrawalContract::FIELD_SUM};
            $d = $endSum - $startSum;
            //dump(compact('startSum', 'endSum', 'd', 'startTimestamp', 'endTimestamp'));

            if ($d === 0.0) {
                continue;
            }

            $companionEmployees = $workShiftEmployees->where('startTimeStamp', '<=', $startTimestamp)
                ->where('endTimeStamp', '>=', $endTimestamp);
            //$companionEmployees = $this->workShiftEmloyeeRepository->getBySameWithdrawalPeriod($workShift->{WorkShiftContract::FIELD_ID}, $startTime, $endTime, $positions);

            if ($companionEmployees->count() === 0) {
                continue;
            }

            $saleAmount = 0;
            if ($companionEmployees->count() > 1) {
                $saleAmount = ($d * (int)$custom->percent_for_multiple / 100) / $companionEmployees->count();
            } else {
                $saleAmount = $d * (int)$custom->percent_for_one / 100;
            }
            //dump([
                //'startTime' => $startTime,
                //'endTime' => $endTime,
                //'d' => $d,
                //'employees' => $companionEmployees->map(function ($item) {
                    //return $item['id'];
                //})->implode(', '),
                ////'custom' => $custom,
                //'saleAmount' => $saleAmount,
            //]);

            foreach ($companionEmployees as $companionEmployee) {
                $data = [
                    WorkShiftPayrollContract::FIELD_WORK_SHIFT_ID => $workShift->{WorkShiftContract::FIELD_ID},
                    WorkShiftPayrollContract::FIELD_EMPLOYEE_ID => $companionEmployee[WorkShiftEmployeeContract::FIELD_ID],
                    WorkShiftPayrollContract::FIELD_AMOUNT => $saleAmount,
                    WorkShiftPayrollContract::FIELD_CALC_TYPE_ID => 1,
                    WorkShiftPayrollContract::FIELD_CALC_TYPE_ID => $calcType->{CalcsTypeContract::FIELD_ID},
                    WorkShiftPayrollContract::FIELD_CUSTOM_DATA => json_encode(compact('startTime', 'endTime')),
                ];
                $payRolls[] = $data;
            }
        }
    }

    public function previewPayrolls(Request $request) {
        $workShift = $this->workShiftRepo->find($request->get('id'));
        $this->savePayrolls($workShift);
        $stats = WorkShiftHelper::recalculateStats($workShift);
        return response()->json([
            'data' => $workShift->id,
            'agenda' => $stats['agenda'],
        ]);
    }

    public function reopen(Request $request)
    {
        $workShift = $this->workShiftRepo->find($request->get('id'));
        if ($workShift->closed_at) {
            $workShift->closed_at = null;
            $workShift->save();
            $workShift->fresh();
        }

        $stats = WorkShiftHelper::recalculateStats($workShift);
        return response()->json([
            'data' => $workShift->id,
            'agenda' => $stats['agenda'],
        ]);
    }

    protected function savePayrolls(WorkShift $workShift) {
        $payRolls = $this->calculatePayrolls($workShift);

        $existingPayRolls = $this->workShiftPayrollRepository->getByWorkShiftID($workShift->{WorkShiftContract::FIELD_ID});

        if ($existingPayRolls->count() > 0) {
            foreach ($existingPayRolls as $payroll) {
                $payroll->delete();
            }
        }

        foreach ($payRolls as $payRoll) {
            WorkShiftPayroll::create($payRoll);
        }
    }

    public function validateEmployeeSalaryData(WorkShiftEmployee $employee)
    {
        $emptySalaryData = [];
        $placeCalcs = $this->placeCalcsRepository->getActiveByPlaceId($employee->workShift->{WorkShiftContract::FIELD_PLACE_ID});
        foreach ($placeCalcs as $placeCalc) {
            $calcType = $placeCalc->calcsType;
            $custom = $calcType->getCustom();
            $userID = $employee->{WorkShiftEmployeeContract::FIELD_USER_ID};
            $calcTypeID = $calcType->{CalcsTypeContract::FIELD_TYPE};


            switch ((int) $calcType->{CalcsTypeContract::FIELD_TYPE}) {
            case 3:
                $employeeStatuses = [];
                if (isset($custom->employee_statuses)) {
                    $employeeStatuses = $custom->employee_statuses;
                }

                if (!in_array($employee->{WorkShiftEmployeeContract::FIELD_STATUS}, $employeeStatuses)) {
                    break;
                }

                $salaryData = $this->userSalaryDataRepository
                    ->getActualSalaryData($userID, $calcTypeID);
                if (!$salaryData) {
                    $emptySalaryData[$calcType->{CalcsTypeContract::FIELD_ID}] = $calcType->{CalcsTypeContract::FIELD_NAME};
                }

                break;
            case 4:
                $employeePositions = [];
                if (isset($custom->positions)) {
                    $employeePositions = $custom->positions;
                }

                if (!in_array($employee->{WorkShiftEmployeeContract::FIELD_POSITION_ID}, $employeePositions)) {
                    break;
                }

                $salaryData = $this->userSalaryDataRepository
                    ->getActualSalaryData($userID, $calcTypeID);

                if (!$salaryData) {
                    $emptySalaryData[$calcType->{CalcsTypeContract::FIELD_ID}] = $calcType->{CalcsTypeContract::FIELD_NAME};
                }

                break;
            }
        }

        return $emptySalaryData;
    }
}
