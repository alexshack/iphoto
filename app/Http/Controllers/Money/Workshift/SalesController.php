<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Helpers\WorkShiftHelper;
use App\Contracts\WorkShift\WorkShiftGoodsContract;
use App\Models\WorkShift\WorkShiftGood;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftGoodsRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    private WorkShiftRepositoryInterface $workShiftRepo;
    private WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository;

    public function __construct(WorkShiftRepositoryInterface $workShiftRepo, WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository)
    {
        $this->workShiftGoodsRepository = $workShiftGoodsRepository;
        $this->workShiftRepo = $workShiftRepo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $goods = $this->workShiftGoodsRepository->getAll($request->get('workshiftID'), $request->get('type'));
        return response()->json($goods);
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
        $validated = $request->validate(WorkShiftGoodsContract::RULES, [], WorkShiftGoodsContract::ATTRIBUTES);

        $good = WorkShiftGood::create($validated);
        $workShift = $this->workShiftRepo->find($request->get('workshift_id'));

        return response()->json([
            'agenda' => WorkShiftHelper::recalculateStats($workShift),
            'data' => $good,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $good = $this->workShiftGoodsRepository->find($id);
        return response()->json($good);

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
        $validated = $request->validate(WorkShiftGoodsContract::RULES, [], WorkShiftGoodsContract::ATTRIBUTES);
        $good = $request->workShiftGoodsRepository->find($id);

        if ($good) {
            foreach ($validated as $key => $value) {
                $good->{$key} = $value;
            }
            $good->save();

            $workShift = $this->workShiftRepo->find($request->get('workshift_id'));
            return response()->json([
                'agenda' => WorkShiftHelper::recalculateStats($workShift),
                'id' => $good->id,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $good = $request->workShiftGoodsRepository->find($id);
        if ($good) {
            $good->delete();
            return response()->json([]);
        }
    }
}
