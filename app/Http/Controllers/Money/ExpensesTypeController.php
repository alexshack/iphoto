<?php

namespace App\Http\Controllers\Money;

use App\Contracts\Money\ExpensesTypeContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Money\CreateExpensesTypeRequest;
use App\Http\Requests\Money\UpdateExpensesTypeRequest;
use App\Models\Money\ExpensesType;
use App\Repositories\Interfaces\ExpensesTypeRepositoryInterface;
use Illuminate\Http\Request;

class ExpensesTypeController extends Controller
{
    private ExpensesTypeRepositoryInterface $expensesTypeRepository;

    public function __construct(ExpensesTypeRepositoryInterface $expensesTypeRepository)
    {
        $this->expensesTypeRepository = $expensesTypeRepository;
    }

    public function index()
    {
        $list = $this->expensesTypeRepository->getAll();
        return view('money.expenses-types')->with(['list' => $list]);
    }

    public function store(CreateExpensesTypeRequest $request)
    {
        try {
            $expensesType = new ExpensesType();
            $expensesType->{ ExpensesTypeContract::FIELD_NAME } = $request->{ ExpensesTypeContract::FIELD_NAME };
            $expensesType->{ ExpensesTypeContract::FIELD_STATUS } = $request->{ ExpensesTypeContract::FIELD_STATUS };
            $expensesType->save();
            $expensesType->roles()->attach($request->role_list);
            return response()->json(['message' => 'Success!'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => [
                'error' => $e->getMessage()
            ], 422]);
        }
    }

    public function update(UpdateExpensesTypeRequest $request, $id)
    {
        try {
            $expensesType = ExpensesType::findOrFail($id);
            $expensesType->update($request->only([ExpensesTypeContract::FIELD_NAME, ExpensesTypeContract::FIELD_STATUS]));
            $expensesType->roles()->sync($request->role_list);
            return response()->json(['message' => 'Success!'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => [
                'error' => $e->getMessage()
            ], 422]);
        }
    }
}
