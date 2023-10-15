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
use App\Repositories\Interfaces\CalcsTypeRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftEmployeeRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftGoodsRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftWithdrawalRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkShiftController extends Controller
{
    private CalcsTypeRepositoryInterface $calcsTypeRepository;
    private WorkShiftEmployeeRepositoryInterface $workShiftEmployeeRepository;
    private WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository;
    private WorkShiftRepositoryInterface $workShiftRepo;
    private WorkShiftWithdrawalRepositoryInterface $workShiftWithdrawalRepository;

    public function __construct(CalcsTypeRepositoryInterface $calcsTypeRepository,
        WorkShiftRepositoryInterface $workShiftRepo,
        WorkShiftEmployeeRepositoryInterface $workShiftEmployeeRepository,
        WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository,
        WorkShiftWithdrawalRepositoryInterface $workShiftWithdrawalRepository) {
        $this->calcsTypeRepository = $calcsTypeRepository;
        $this->workShiftGoodsRepository = $workShiftGoodsRepository;
        $this->workShiftRepo = $workShiftRepo;
        $this->workShiftEmloyeeRepository = $workShiftEmployeeRepository;
        $this->workShiftWithdrawalRepository = $workShiftWithdrawalRepository;
    }

    public function close(Request $request) {
        $workShift = $this->workShiftRepo->find($request->get('id'));

        $stats = WorkShiftHelper::recalculateStats($workShift);

        if ($stats['access']['closable']) {
            $workShift->{WorkShiftContract::FIELD_CLOSED} = true;
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
            $custom = $calcType->getCustom();
            switch ($calcType->{CalcsTypeContract::FIELD_TYPE}) {
            case 1:
                $positions = [];
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
                    ];

                    $payRolls[] = $data;
                }
                break;
            case 2:
                $individualSales = $this->workShiftGoodsRepository->getAll($workShift->{WorkShiftContract::FIELD_ID}, 2);
                foreach ($individualSales as $sale) {
                    $data = [
                        WorkShiftPayrollContract::FIELD_WORK_SHIFT_ID => $workShift->{WorkShiftContract::FIELD_ID},
                        WorkShiftPayrollContract::FIELD_EMPLOYEE_ID => $sale->{WorkShiftGoodsContract::FIELD_EMPLOYEE_ID},
                        WorkShiftPayrollContract::FIELD_AMOUNT => $sale->{WorkShiftGoodsContract::FIELD_PRICE},
                    ];
                    $payRolls[] = $data;
                }
                break;
            default:
                break;
            }
        }

        dump($payRolls);
    }
}
