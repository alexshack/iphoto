<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Contracts\WorkShift\WorkShiftGoodsContract;
use App\Models\WorkShift\WorkShiftGood;
use App\Repositories\Interfaces\WorkShiftGoodsRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    private WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository;

    public function __construct(WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository)
    {
        $this->workShiftGoodsRepository = $workShiftGoodsRepository;
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

        return response()->json([
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

            return response()->json([
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
