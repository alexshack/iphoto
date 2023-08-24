<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Contracts\WorkShift\WorkShiftEmployeeContract;
use App\Http\Controllers\Controller;
use App\Models\WorkShift\WorkShiftEmployee;
use App\Repositories\Interfaces\WorkShiftEmployeeRepositoryInterface;
use Illuminate\Http\Request;

class WorkshiftEmployeeController extends Controller
{

    private WorkShiftEmployeeRepositoryInterface $employeeRepo;

    public function __construct(WorkShiftEmployeeRepositoryInterface $employeeRepo) {
        $this->employeeRepo = $employeeRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employees = $this->employeeRepo->getAll($request->get('workshiftID'));
        return response()->json($employees);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(WorkShiftEmployeeContract::RULES, [], WorkShiftEmployeeContract::ATTRIBUTES);

        $employee = WorkShiftEmployee::create($request->all());

        return response()->json($employee);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = $this->employeeRepo->find($id);
        return response()->json($employee);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate(WorkShiftEmployeeContract::RULES, [], WorkShiftEmployeeContract::ATTRIBUTES);

        $employee = $this->employeeRepo->find($id);
        if ($employee) {
            foreach ($validated as $key => $value) {
                $employee->{$key} = $value;
            }
            $employee->save();
            return response()->json(['id' => $employee->id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = $this->employeeRepo->find($id);
        if ($employee) {
            $employee->delete();
            return response()->json(['message' => 'Сотрудник удален со смены']);
        }
    }
}
