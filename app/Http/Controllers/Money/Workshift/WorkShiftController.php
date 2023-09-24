<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Contracts\WorkShift\WorkShiftContract;
use App\Helpers\WorkShiftHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftGoodsRepositoryInterface;
use Illuminate\Http\Request;

class WorkShiftController extends Controller
{
    private WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository;
    private WorkShiftRepositoryInterface $workShiftRepo;

    public function __construct(WorkShiftRepositoryInterface $workShiftRepo, WorkShiftGoodsRepositoryInterface $workShiftGoodsRepository) {
        $this->workShiftGoodsRepository = $workShiftGoodsRepository;
        $this->workShiftRepo = $workShiftRepo;
    }

    public function close(Request $request) {
        $workShift = $this->workShiftRepo->find($request->get('id'));

        $stats = WorkShiftHelper::recalculateStats($workShift);

        if ($stats['access']['closable']) {
            $workShift->{WorkShiftContract::FIELD_CLOSED} = true;
            $workShift->save();
        }

        $stats = WorkShiftHelper::recalculateStats($workShift);

        return response()->json([
            'data' => $workShift->id,
            'agenda' => $stats['agenda'],
        ]);
    }
}
