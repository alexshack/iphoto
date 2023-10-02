<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Contracts\Salary\PaysContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Helpers\WorkShiftHelper;
use App\Http\Controllers\Controller;
use App\Models\Salary\Pay;
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
        if (!$type) {
            $type = 2;
        }
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
        $month = $request->get('month');
        $workShift = $this->workShiftRepo->find($request->get('workshift_id'));
        $request->request->add([
            PaysContract::FIELD_BILLING_MONTH => "{$month['year']}-{$month['month']}-01",
            PaysContract::FIELD_TYPE => 2,
            PaysContract::FIELD_CITY_ID => $workShift->{WorkShiftContract::FIELD_CITY_ID},
            PaysContract::FIELD_SOURCE_TYPE => 2,
            PaysContract::FIELD_SOURCE_ID => $workShift->{WorkShiftContract::FIELD_PLACE_ID},
            PaysContract::FIELD_DATE => $workShift->{WorkShiftContract::FIELD_DATE},
        ]);
        $validated = $request->validate(PaysContract::RULES, [], PaysContract::ATTRIBUTES);
        $pay = Pay::create($validated);
        return response()->json([
            'agenda' => WorkShiftHelper::recalculateStats($workShift),
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
            $workShift = $this->workShiftRepo->find($request->get('workshift_id'));
            return response()->json([
                'agenda' => WorkShiftHelper::recalculateStats($workShift),
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
