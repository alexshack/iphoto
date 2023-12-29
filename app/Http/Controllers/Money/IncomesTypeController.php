<?php

namespace App\Http\Controllers\Money;

use App\Http\Controllers\Controller;
use App\Http\Requests\Money\CreateEmployeeStatusRequest;
use App\Http\Requests\Money\CreateIncomesTypeRequest;
use App\Http\Requests\Money\UpdateIncomesTypeRequest;
use App\Models\Money\IncomesType;
use App\Repositories\Interfaces\IncomesTypeRepositoryInterface;
use Illuminate\Http\Request;

class IncomesTypeController extends Controller
{
    private IncomesTypeRepositoryInterface $incomesTypeRepository;

    public function __construct(IncomesTypeRepositoryInterface $incomesTypeRepository)
    {
        $this->incomesTypeRepository = $incomesTypeRepository;
    }

    public function index()
    {
        $list = $this->incomesTypeRepository->getAll();
        return view('money.incomes-types')->with(['list' => $list]);
    }

    public function store(CreateIncomesTypeRequest $request)
    {
        try {
            IncomesType::create($request->validated());
            return response()->json(['message' => 'Success!'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => [
                'error' => $e->getMessage()
            ], 422]);
        }
    }

    public function update(UpdateIncomesTypeRequest $request, $id)
    {
        try {
            IncomesType::findOrFail($id)->update($request->validated());
            return response()->json(['message' => 'Success!'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => [
                'error' => $e->getMessage()
            ], 422]);
        }
    }
}
