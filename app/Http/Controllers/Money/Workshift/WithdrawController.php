<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Contracts\Workshift\WorkShiftWithdrawalContract;
use App\Http\Controllers\Controller;
use App\Models\WorkShift\WorkShiftWithdrawal;
use App\Repositories\Interfaces\WorkShiftWithdrawalRepositoryInterface;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    private WorkShiftWithdrawalRepositoryInterface $withdrawRepo;

    public function __construct(WorkShiftWithdrawalRepositoryInterface $withdrawRepo)
    {
        $this->withdrawRepo = $withdrawRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $withdrawals = $this->withdrawRepo->getByWorkShift($request->get('workshiftID'));
        return response()->json($withdrawals);

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
        $validated = $request->validate(WorkShiftWithdrawalContract::RULES, []. WorkShiftWithdrawalContract::ATTRIBUTES);

        $withdraw = WorkShiftWithdrawal::create($validated);

        return response()->json([
            'data' => $withdraw,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $withdraw = $this->withdrawRepo->find($id);
        return response()->json($withdraw);
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
        $validated = $request->validate(WorkShiftWithdrawalContract::RULES, []. WorkShiftWithdrawalContract::ATTRIBUTES);
        $withdraw = $this->withdrawRepo->find($id);

        if ($withdraw) {
            foreach ($validated as $key => $value) {
                $withdraw->{$key} = $value;
            }
            $withdraw->save();

            return response()->json(['id' => $withdraw->id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
