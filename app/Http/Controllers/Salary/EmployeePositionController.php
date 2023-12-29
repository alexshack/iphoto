<?php

namespace App\Http\Controllers\Salary;

use App\Http\Controllers\Controller;
use App\Http\Requests\Salary\CreateEmployeePositionRequest;
use App\Http\Requests\Salary\UpdateEmployeePositionRequest;
use App\Models\Salary\Position;
use App\Repositories\Interfaces\EmployeePositionRepositoryInterface;
use Illuminate\Http\Request;

class EmployeePositionController extends Controller
{
    private EmployeePositionRepositoryInterface $employeePositionRepository;

    public function __construct(EmployeePositionRepositoryInterface $employeePositionRepository)
    {
        $this->employeePositionRepository = $employeePositionRepository;
    }

    public function index()
    {
        $list = $this->employeePositionRepository->getAll();
        return view('salary.employee-positions')->with(['list' => $list]);
    }

    public function store(CreateEmployeePositionRequest $request)
    {
        try {
            Position::create($request->validated());
            return response()->json(['message' => 'Success!'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => [
                'error' => $e->getMessage()
            ], 422]);
        }
    }

    public function update(UpdateEmployeePositionRequest $request, $id)
    {
        try {
            Position::findOrFail($id)->update($request->validated());
            return response()->json(['message' => 'Success!'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => [
                'error' => $e->getMessage()
            ], 422]);
        }
    }
}
