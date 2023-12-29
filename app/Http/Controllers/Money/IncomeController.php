<?php

namespace App\Http\Controllers\Money;

use App\Contracts\Money\IncomeContract;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Money\CreateIncomeRequest;
use App\Http\Requests\Money\UpdateIncomeRequest;
use App\Models\Money\Income;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\IncomeRepositoryInterface;
use App\Repositories\Interfaces\IncomesTypeRepositoryInterface;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    protected IncomeRepositoryInterface $incomeRepository;

    public function __construct(IncomeRepositoryInterface $incomeRepository)
    {
        $this->incomeRepository = $incomeRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filter = [
            'month' => date('m'),
            'year' => date('Y')
        ];
        if(request()->query('filter')) {
            $filter = Helper::dateFilterFormat(request()->query('filter'));
        }
        $list = $this->incomeRepository->getByFilter($filter);
        return view('money.incomes')->with(['list' => $list]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('money.income');
    }

    /**
     * Display the specified resource.
     */
    public function show(Income $income)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $income = Income::findOrFail($id);
        return view('money.income')
            ->with([
                       'income'   => $income,
                   ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $income = Income::findOrFail($id);
        try {
            $income->delete();
            return back()->with('messages', 'Поступление ДС успешно удалено!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Ошибка базы данных!']);
        }
    }
}
