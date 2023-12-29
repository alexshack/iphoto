<?php

namespace App\Http\Controllers\Money;

use App\Contracts\Money\ExpenseContract;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ExpensesRepositoryInterface;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    private ExpensesRepositoryInterface $expensesRepository;

    public function __construct(ExpensesRepositoryInterface $expensesRepository) {
        $this->expensesRepository = $expensesRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = $this->expensesRepository->getAll();
        $types = [
            'manager' => ExpenseContract::TYPE_MANAGER,
            'place' => ExpenseContract::TYPE_PLACE,
        ];
        return view('money.expenses', compact('expenses', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('money.expense');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $expense = $this->expensesRepository->find($id);
        return view('money.expense', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
