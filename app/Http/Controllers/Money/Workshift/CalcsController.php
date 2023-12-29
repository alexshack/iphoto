<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Contracts\Salary\CalcsContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Http\Controllers\Controller;
use App\Models\WorkShift\WorkShift;
use App\Repositories\Interfaces\CalcsRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use Illuminate\Http\Request;

class CalcsController extends Controller
{
    private CalcsRepositoryInterface $payRepo;
    private WorkShiftRepositoryInterface $workShiftRepo;

    public function __construct(CalcsRepositoryInterface $payRepo, WorkShiftRepositoryInterface $workShiftRepo)
    {
        $this->payRepo = $payRepo;
        $this->workShiftRepo = $workShiftRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $workShift = $this->workShiftRepo->find($request->get('workshiftID'));
        if ($workShift) {
            $calcs = $this->payRepo->getByWorkshift($workShift);
        }
        return response()->json($calcs);
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
    public function edit(string $id)
    {
        //
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
