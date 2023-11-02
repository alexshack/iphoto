<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Contracts\Goods\GoodsContract;
use App\Contracts\Salary\CalcsTypeContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Contracts\WorkShift\WorkShiftEmployeeContract;
use App\Contracts\WorkShift\WorkShiftGoodsContract;
use App\Contracts\WorkShift\WorkShiftPayrollContract;
use App\Contracts\WorkShift\WorkShiftWithdrawalContract;
use App\Helpers\WorkShiftHelper;
use App\Http\Controllers\Controller;
use App\Models\WorkShift\WorkShift;
use App\Models\WorkShift\WorkShiftPayroll;
use App\Repositories\Interfaces\CalcsTypeRepositoryInterface;
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
    private WorkShiftEmployeeRepositoryInterface $workShiftEmployeeRepository;
    private WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository;
    private WorkShiftPayrollRepositoryInterface $workShiftPayrollRepository;
    private WorkShiftRepositoryInterface $workShiftRepo;
    private WorkShiftWithdrawalRepositoryInterface $workShiftWithdrawalRepository;

    public function __construct(CalcsTypeRepositoryInterface $calcsTypeRepository,
        WorkShiftRepositoryInterface $workShiftRepo,
        WorkShiftEmployeeRepositoryInterface $workShiftEmployeeRepository,
        WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository,
        WorkShiftPayrollRepositoryInterface $workShiftPayrollRepository,
        WorkShiftWithdrawalRepositoryInterface $workShiftWithdrawalRepository) {
        $this->calcsTypeRepository = $calcsTypeRepository;
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

        $calcsTypes = $this->calcsTypeRepository->getActive();
        $employees = $this->workShiftEmloyeeRepository->getAll($workShift->{WorkShiftContract::FIELD_ID});
        foreach ($calcsTypes as $calcType) {
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

        dump($payRolls);
    }

    protected function handleSalaryCalcType(WorkShift $workShift, $calcType, &$payRolls, $employees)
    {
        $employeeStatuses = [];
        $custom = $calcType->getCustom();
        if (isset($custom->employeeStatuses)) {
            $positions = $custom->employeeStatuses;
        }

        $calcTypeEmployees = $employees->filter(function ($employee) use ($employeeStatuses) {
            return in_array($employee->{WorkShiftEmployeeContract::FIELD_STATUS}, $employeeStatuses);
        });

        foreach ($calcTypeEmployees as $employee) {
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
}
