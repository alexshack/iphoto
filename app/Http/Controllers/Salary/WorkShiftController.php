<?php

namespace App\Http\Controllers\Salary;

use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkShiftController extends Controller
{
    private WorkShiftRepositoryInterface $workshiftRepository;

    public function __construct(WorkShiftRepositoryInterface $workshiftRepository) {
        $this->workshiftRepository = $workshiftRepository;
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
        $period = null;
        if(request()->query('filter')) {
            $filter = Helper::dateFilterFormat(request()->query('filter'));
            $period = request()->query('filter');
        } else {
            $month = Helper::getMonthName((int)date('m'));
            $year = date('Y');
            $period = "$month $year";
        }
        $workshifts = $this->workshiftRepository->getByFilter($filter);

        return view('money.days', compact('workshifts', 'period'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $workshift = $this->workshiftRepository->find($id);
        return view('money.day', compact('workshift'));
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
