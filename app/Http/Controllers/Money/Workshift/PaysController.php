<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PaysRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use App\Models\Salary\Salary;
use App\Models\WorkShift\WorkShift;
use Illuminate\Http\Request;

class PaysController extends Controller
{
    private PaysRepositoryInterface $payRepo;
    private WorkShiftRepositoryInterface $workShiftRepo;

    public function __construct(PaysRepositoryInterface $payRepo, WorkShiftRepositoryInterface $workShiftRepo)
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
        $type = $request->get('type');
        $pays = [];
        if ($workShift) {
            $pays = $this->payRepo->getByWorkshift($workShift, $type);
        }
        return response()->json($pays);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(PaysContract::RULES, [], PaysContract::ATTRIBUTES);
        $pay = Pay::store($validated);
        return response()->json([
            'data' => $pay,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pay = $this->payRepo->find($id);
        return response()->json($pay);
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
        $pay = $this->payRepo->find($id);
        $validated = $request->validate(PaysContract::RULES, [], PaysContract::ATTRIBUTES);
        if ($pay) {
            foreach ($validated as $key => $value) {
                $pay->{$key} = $value;
            }
            $pay->save();
            return response()->json([
                'id' => $pay->id,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pay = $this->payRepo->find($id);
        if ($pay) {
            $pay->delete();
            return response()->json([]);
        }
    }
}
