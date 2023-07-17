<?php

namespace App\Http\Controllers\Salary;

use App\Http\Controllers\Controller;
use App\Http\Requests\Salary\CreateEmployeeStatusRequest;
use App\Http\Requests\Salary\UpdateEmployeeStatusRequest;
use App\Models\Salary\EmployeeStatuses;
use App\Repositories\Interfaces\EmployeeStatusRepositoryInterface;
use Illuminate\Http\Request;

class EmployeeStatusController extends Controller
{
    private EmployeeStatusRepositoryInterface $employeeStatusRepository;

    public function __construct(EmployeeStatusRepositoryInterface $employeeStatusRepository)
    {
        $this->employeeStatusRepository = $employeeStatusRepository;
    }

    public function index()
    {
        $list = $this->employeeStatusRepository->getAll();
        return view('salary.employee-statuses')->with(['list' => $list]);
    }

    public function store(CreateEmployeeStatusRequest $request)
    {
        try {
            EmployeeStatuses::create($request->validated());
            return response()->json(['message' => 'Success!'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => [
                'error' => $e->getMessage()
            ], 422]);
        }
    }

    public function update(UpdateEmployeeStatusRequest $request, $id)
    {
        try {
            EmployeeStatuses::findOrFail($id)->update($request->validated());
            return response()->json(['message' => 'Success!'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => [
                'error' => $e->getMessage()
            ], 422]);
        }
    }
}
