<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Contracts\WorkShift\WorkShiftFinalCashDeskContract;
use App\Helpers\WorkShiftHelper;
use App\Http\Controllers\Controller;
use App\Models\WorkShift\WorkShiftFinalCashDesk;
use App\Repositories\Interfaces\WorkShiftFinalCashDeskRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use Illuminate\Http\Request;

class FCDController extends Controller
{
    private WorkShiftFinalCashDeskRepositoryInterface $fcdRepo;
    private WorkShiftRepositoryInterface $workShiftRepo;

    public function __construct(WorkShiftFinalCashDeskRepositoryInterface $fcdRepo, WorkShiftRepositoryInterface $workShiftRepo)
    {
        $this->fcdRepo = $fcdRepo;
        $this->workShiftRepo = $workShiftRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $workShift = $this->workShiftRepo->find($request->get('workshiftID'));
        if (!$workShift) {
            return;
        }

        $fcds = $this->fcdRepo->getByWorkshift($workShift);
        return response()->json($fcds);
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
        $workShift = $this->workShiftRepo->find($request->get('workshift_id'));
        //$request->request->add
        $validated = $request->validate(WorkShiftFinalCashDeskContract::RULES, [], WorkShiftFinalCashDeskContract::ATTRIBUTES);
        $fcd = WorkShiftFinalCashDesk::create($validated);
        $stats = WorkShiftHelper::recalculateStats($workShift);
        return response()->json([
            'data' => $fcd,
            'agenda' => $stats['agenda'],
            'errors' => $stats['errors'],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fcd = $this->fcdRepo->find($id);
        return response()->json($fcd);
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
        $workShift = $this->workShiftRepo->find($request->get('workshift_id'));
        $validated = $request->validate(WorkShiftFinalCashDeskContract::RULES, [], WorkShiftFinalCashDeskContract::ATTRIBUTES);
        $fcd = $this->fcdRepo->find($id);

        if ($fcd) {
            foreach ($validated as $key => $value) {
                $fcd->{$key} = $value;
            }
            $fcd->save();

            $stats = WorkShiftHelper::recalculateStats($workShift);
            return response()->json([
                'id' => $fcd->id,
                'agenda' => $stats['agenda'],
                'errors' => $stats['errors'],
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fcd = $this->fcdRepo->find($id);
        if ($fcd) {
            $fcd->delete();
            return response()->json([]);
        }
    }
}
