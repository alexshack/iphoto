<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Http\Controllers\Controller;
use App\Models\Money\Expense;
use App\Models\WorkShift\WorkShift;
use App\Repositories\Interfaces\ExpensesRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    private ExpensesRepositoryInterface $expenseRepo;
    private WorkShiftRepositoryInterface $workShiftRepo;

    public function __construct(ExpensesRepositoryInterface $expenseRepo,
        WorkShiftRepositoryInterface $workShiftRepo)
    {
        $this->expenseRepo = $expenseRepo;
        $this->workShiftRepo = $workShiftRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $expenses = [];
        $workShift = $this->workShiftRepo->find($request->get('workshiftID'));
        $expenses = $this->expenseRepo->getByWorkshift($workShift);
        return response()->json($expenses);
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
        $validated = $request->validate(ExpenseContract::RULES, [], ExpenseContract::ATTRIBUTES);
        $expense = Expense::store($validated);
        return response()->json([
            'data' => $expense,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $expense = $this->expenseRepo->find($id);
        return response()->json($expense);
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
        $validated = $request->validate(ExpenseContract::RULES, [], ExpenseContract::ATTRIBUTES);
        $expense = $this->expenseRepo->find($id);
        if ($expense) {
            foreach ($validated as $key => $value) {
                $expense->{$key} = $value;
            }
            $expense->save();
            return response()->json([
                'id' => $expense->id,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expense = $this->expenseRepo->find($id);
        if ($expense) {
            $expense->delete();
            return response()->json([]);
        }
    }
}
