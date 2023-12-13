<?php

namespace App\Http\Controllers\Salary;

use App\Contracts\Salary\CalcsTypeContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Salary\CreateCalcTypeRequest;
use App\Http\Requests\Salary\UpdateCalcTypeRequest;
use App\Models\Salary\CalcsType;
use App\Repositories\Interfaces\CalcsTypeRepositoryInterface;
use App\Repositories\Interfaces\EmployeePositionRepositoryInterface;
use App\Repositories\Interfaces\EmployeeStatusRepositoryInterface;
use Illuminate\Http\Request;

class CalcsTypeController extends Controller
{
    private CalcsTypeRepositoryInterface $calcsTypeRepository;
    private EmployeePositionRepositoryInterface $employeePositionRepository;
    private EmployeeStatusRepositoryInterface $employeeStatusRepository;

    public function __construct(CalcsTypeRepositoryInterface $calcsTypeRepository, EmployeePositionRepositoryInterface $employeePositionRepository, EmployeeStatusRepositoryInterface $employeeStatusRepository)
    {
        $this->calcsTypeRepository = $calcsTypeRepository;
        $this->employeePositionRepository = $employeePositionRepository;
        $this->employeeStatusRepository = $employeeStatusRepository;
    }

    public function index()
    {
        $list = $this->calcsTypeRepository->getAll();

        return view('salary.calcs-types')->with(['list' => $list]);
    }

    public function create()
    {
        $positions = $this->employeePositionRepository->getAll();
        $statuses = $this->employeeStatusRepository->getAll();
        return view('salary.calcs-type')->with(['positions' => $positions, 'statuses' => $statuses]);
    }

    public function store(CreateCalcTypeRequest $request)
    {
        try {
            $calcsType = new CalcsType();
            $calcsType->{ CalcsTypeContract::FIELD_TYPE } = $request->{ CalcsTypeContract::FIELD_TYPE };
            $calcsType->{ CalcsTypeContract::FIELD_NAME } = $request->{ CalcsTypeContract::FIELD_NAME };
            $calcsType->{ CalcsTypeContract::FIELD_STATUS } = $request->{ CalcsTypeContract::FIELD_STATUS };
            $calcsType->{ CalcsTypeContract::FIELD_AUTOMATIC_CALCULATION } = (isset($request->{ CalcsTypeContract::FIELD_AUTOMATIC_CALCULATION })) ? 1 : null;
            $calcsType->{ CalcsTypeContract::FIELD_SALARY_PAYMENT } = (isset($request->{ CalcsTypeContract::FIELD_SALARY_PAYMENT })) ? 1 : null;
            $calcsType->{ CalcsTypeContract::FIELD_CUSTOM_DATA } = json_encode( $request->{ CalcsTypeContract::FIELD_CUSTOM_DATA });
            $calcsType->save();
            return redirect()->to(route('admin.salary.calc_type.edit', ['id' => $calcsType->{ CalcsTypeContract::FIELD_ID }]))->with('message', 'Тип начисления успешно добавлен!');
        } catch (\Exception $e)  {
            return back()->withErrors(['error' => 'Ошибка базы данных!']);
        }
    }

    public function edit($id)
    {
        $calcsType = CalcsType::findOrFail($id);
        $positions = $this->employeePositionRepository->getAll();
        $statuses = $this->employeeStatusRepository->getAll();

        //if ($calcsType->{ CalcsTypeContract::FIELD_TYPE } === 3) {
            //$custom = $calcsType->get
        //}

        return view('salary.calcs-type')->with(['type' => $calcsType, 'positions' => $positions, 'statuses' => $statuses]);
    }

    public function update(UpdateCalcTypeRequest $request, $id)
    {
        $calcsType = CalcsType::findOrFail($id);
        try {
            $calcsType->{ CalcsTypeContract::FIELD_NAME } = $request->{ CalcsTypeContract::FIELD_NAME };
            $calcsType->{ CalcsTypeContract::FIELD_STATUS } = $request->{ CalcsTypeContract::FIELD_STATUS };
            $calcsType->{ CalcsTypeContract::FIELD_AUTOMATIC_CALCULATION } = (isset($request->{ CalcsTypeContract::FIELD_AUTOMATIC_CALCULATION })) ? 1 : null;
            $calcsType->{ CalcsTypeContract::FIELD_SALARY_PAYMENT } = (isset($request->{ CalcsTypeContract::FIELD_SALARY_PAYMENT })) ? 1 : null;
            $calcsType->{ CalcsTypeContract::FIELD_CUSTOM_DATA } = json_encode( $request->{ CalcsTypeContract::FIELD_CUSTOM_DATA });
            $calcsType->save();
            return back()->with('message', 'Тип начисления успешно изменен!');
        } catch (\Exception $e)  {
            return back()->withErrors(['error' => 'Ошибка базы данных!']);
        }
    }
}
