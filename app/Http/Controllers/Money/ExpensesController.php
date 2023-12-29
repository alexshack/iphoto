<?php

namespace App\Http\Controllers\Money;

use App\Components\AccessManager\Interfaces\IAccessManager;
use App\Contracts\Money\ExpenseContract;
use App\Contracts\UserWorkDataContract;
use App\Http\Controllers\Controller;
use App\Models\WorkShift\WorkShift;
use App\Repositories\Interfaces\ExpensesRepositoryInterface;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    private ExpensesRepositoryInterface $expensesRepository;
    private IAccessManager $accessManager;

    public function __construct(
        ExpensesRepositoryInterface $expensesRepository,
        IAccessManager $accessManager
    ) {
        $this->expensesRepository = $expensesRepository;
        $this->accessManager = $accessManager;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cityId = $request->query(UserWorkDataContract::FIELD_CITY_ID);
        $access = $this->accessManager->checkFieldsAccess([
            UserWorkDataContract::FIELD_CITY_ID => $cityId,
        ]);
        if (!$access) {
            abort(403, 'Доступ запрещен!');
        }

        if ($cityId) {
            $workshift = new WorkShift([
                ExpenseContract::FIELD_CITY_ID => $cityId,
            ]);
            $expenses = $this->expensesRepository->getByWorkshift($workshift);
        } else {
            $expenses = $this->expensesRepository->getAll();
        }

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
