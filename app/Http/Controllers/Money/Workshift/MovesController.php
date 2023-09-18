<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Helpers\WorkShiftHelper;
use App\Http\Controllers\Controller;
use App\Models\Money\Move;
use App\Models\WorkShift\WorkShiftGood;
use App\Repositories\Interfaces\MovesRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use Illuminate\Http\Request;

class MovesController extends Controller
{
    private MovesRepositoryInterface $movesRepo;
    private WorkShiftRepositoryInterface $workShiftRepo;

    public function __construct(MovesRepositoryInterface $movesRepo,
        WorkShiftRepositoryInterface $workShiftRepo)
    {
        $this->movesRepo = $movesRepo;
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
        $moves = $this->movesRepo->getByWorkshift($workShift);
        return response()->json($moves);
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
        $workShift = $this->workShiftRepo->find($request->get('workshiftID'));
        $validated = $request->validate(MovesContract::RULES, [], MovesContract::ATTRIBUTES);
        $move = Move::store($validated);
        return response()->json([
            'agenda' => WorkShiftHelper::recalculateStats($workShift),
            'data' => $move,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $move = $this->movesRepo->find($id);
        return response()->json($move);
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
        $validated = $request->validate(MovesContract::RULES, [], MovesContract::ATTRIBUTES);
        $move = $this->movesRepo->find($id);

        if ($move) {
            foreach ($validated as $key => $value) {
                $move->{$key} = $value;
            }
            $move->save();
            return response()->json([
                'agenda' => WorkShiftHelper::recalculateStats($workShift),
                'id' => $move->id,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $move = $this->movesRepo->find($id);
        if ($move) {
            $move->delete();
            return response()->json([]);
        }
    }
}
