<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Contracts\Goods\GoodsContract;
use App\Contracts\Salary\CalcsTypeContract;
use App\Contracts\Structure\PlaceCalcContract;
use App\Contracts\UserSalaryDataContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Contracts\WorkShift\WorkShiftEmployeeContract;
use App\Contracts\WorkShift\WorkShiftGoodsContract;
use App\Contracts\WorkShift\WorkShiftPayrollContract;
use App\Contracts\WorkShift\WorkShiftWithdrawalContract;
use App\Helpers\WorkShiftHelper;
use App\Http\Controllers\Controller;
use App\Models\WorkShift\WorkShift;
use App\Models\WorkShift\WorkShiftEmployee;
use App\Models\WorkShift\WorkShiftPayroll;
use App\Repositories\Interfaces\CalcsTypeRepositoryInterface;
use App\Repositories\Interfaces\PlaceCalcRepositoryInterface;
use App\Repositories\Interfaces\UserSalaryDataRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftEmployeeRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftGoodsRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftPayrollRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftWithdrawalRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkShiftController extends Controller
{
    private CalcsTypeRepositoryInterface $calcsTypeRepository;
    private PlaceCalcRepositoryInterface $placeCalcsRepository;
    private UserSalaryDataRepositoryInterface $userSalaryDataRepository;
    private WorkShiftEmployeeRepositoryInterface $workShiftEmployeeRepository;
    private WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository;
    private WorkShiftPayrollRepositoryInterface $workShiftPayrollRepository;
    private WorkShiftRepositoryInterface $workShiftRepo;
    private WorkShiftWithdrawalRepositoryInterface $workShiftWithdrawalRepository;

    public function __construct(CalcsTypeRepositoryInterface $calcsTypeRepository,
        PlaceCalcRepositoryInterface $placeCalcsRepository,
        UserSalaryDataRepositoryInterface $userSalaryDataRepository,
        WorkShiftRepositoryInterface $workShiftRepo,
        WorkShiftEmployeeRepositoryInterface $workShiftEmployeeRepository,
        WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository,
        WorkShiftPayrollRepositoryInterface $workShiftPayrollRepository,
        WorkShiftWithdrawalRepositoryInterface $workShiftWithdrawalRepository) {
        $this->calcsTypeRepository = $calcsTypeRepository;
        $this->placeCalcsRepository = $placeCalcsRepository;
        $this->userSalaryDataRepository = $userSalaryDataRepository;
        $this->workShiftGoodsRepository = $workShiftGoodsRepository;
        $this->workShiftRepo = $workShiftRepo;
        $this->workShiftEmloyeeRepository = $workShiftEmployeeRepository;
        $this->workShiftWithdrawalRepository = $workShiftWithdrawalRepository;
        $this->workShiftPayrollRepository = $workShiftPayrollRepository;
    }

    public function close(Request $request) {
        $workShift = $this->workShiftRepo->find($request->get('id'));

        $stats = WorkShiftHelper::recalculateStats($workShift);

        if ($stats['access']['closable']) {
            $workShift->{WorkShiftContract::FIELD_CLOSED_AT} = Carbon::now();
            $workShift->save();
        }

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

        $payRolls = [];

        $placeCalcs = $this->placeCalcsRepository->getActiveByPlaceId($workShift->{WorkShiftContract::FIELD_PLACE_ID});
        $employees = $this->workShiftEmloyeeRepository->getAll($workShift->{WorkShiftContract::FIELD_ID});
        foreach ($placeCalcs as $placeCalc) {
            $calcType = $placeCalc->calcsType;
            switch ($calcType->{CalcsTypeContract::FIELD_TYPE}) {
            case 1:
                $this->handlePercentCalcType($workShift, $calcType, $payRolls, $employees);
                break;
            case 2:
                $this->handleSaleCalcType($workShift, $calcType, $payRolls, $employees);
                break;
            case 3:
                $this->handleSalaryCalcType($workShift, $calcType, $payRolls, $employees);
                break;
            case 4:
                $this->handleFixSalaryCalcType($workShift, $calcType, $payRolls, $employees);
                break;
            default:
                break;
            }
        }

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
                WorkShiftPayrollContract::FIELD_CALC_TYPE_ID => 4,
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
                WorkShiftPayrollContract::FIELD_CALC_TYPE_ID => 3,
            ];
            $payRolls[] = $data;
        }
    }

    protected function handleSaleCalcType(WorkShift $workShift, $calcType, &$payRolls, $employees) {
        $individualSales = $this->workShiftGoodsRepository->getAll($workShift->{WorkShiftContract::FIELD_ID}, 2);
        foreach ($individualSales as $sale) {
            $data = [
                WorkShiftPayrollContract::FIELD_WORK_SHIFT_ID => $workShift->{WorkShiftContract::FIELD_ID},
                WorkShiftPayrollContract::FIELD_EMPLOYEE_ID => $sale->{WorkShiftGoodsContract::FIELD_EMPLOYEE_ID},
                WorkShiftPayrollContract::FIELD_AMOUNT => $sale->{WorkShiftGoodsContract::FIELD_PRICE},
                WorkShiftPayrollContract::FIELD_CALC_TYPE_ID => 2,
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

        foreach ($calcTypeEmployees as $employee) {
            if (!$employee->{WorkShiftEmployeeContract::FIELD_END_TIME}) {
                continue;
            }

            $companionEmployees = $this->workShiftEmloyeeRepository->companions($employee, $positions);
            $saleAmount = 0;

            $employeeStartWithdrawal = $this->workShiftWithdrawalRepository->getByTime($workShift->{WorkShiftContract::FIELD_ID}, $employee->{WorkShiftEmployeeContract::FIELD_START_TIME});
            $employeeEndWithdrawal = $this->workShiftWithdrawalRepository->getByTime($workShift->{WorkShiftContract::FIELD_ID}, $employee->{WorkShiftEmployeeContract::FIELD_END_TIME});

            if ($employeeStartWithdrawal && $employeeEndWithdrawal) {
                $d = (float) $employeeEndWithdrawal->{WorkShiftWithdrawalContract::FIELD_SUM} - (float) $employeeStartWithdrawal->{WorkShiftWithdrawalContract::FIELD_SUM};
            } else {
                continue;
            }

            if ($companionEmployees->count() > 0) {
                $saleAmount = ($d * (int)$custom->percent_for_multiple / 100) / $companionEmployees->count();
            } else {
                $saleAmount = $d * (int)$custom->percent_for_one / 100;
            }

            $data = [
                WorkShiftPayrollContract::FIELD_WORK_SHIFT_ID => $workShift->{WorkShiftContract::FIELD_ID},
                WorkShiftPayrollContract::FIELD_EMPLOYEE_ID => $employee->{WorkShiftEmployeeContract::FIELD_ID},
                WorkShiftPayrollContract::FIELD_AMOUNT => $saleAmount,
                WorkShiftPayrollContract::FIELD_CALC_TYPE_ID => 1,
            ];

            $payRolls[] = $data;
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
