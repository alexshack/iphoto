<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Contracts\WorkShift\WorkShiftVisitorContract;
use App\Helpers\WorkShiftHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftVisitorsRepositoryInterface;
use Illuminate\Http\Request;

class WorkShiftVisitorsController extends Controller
{
    private WorkShiftVisitorsRepositoryInterface $visitorsRepository;
    private WorkShiftRepositoryInterface $workShiftRepo;

    public function __construct(WorkShiftRepositoryInterface $workShiftRepo, WorkShiftVisitorsRepositoryInterface $visitorsRepository)
    {
        $this->visitorsRepository = $visitorsRepository;
        $this->workShiftRepo = $workShiftRepo;
    }

    public function index(Request $request)
    {
        $visitors = $this->visitorsRepository->getByWorkShiftID($request->get('workshiftID'));
        return response()->json($visitors);
    }

    public function update(Request $request)
    {
        foreach ($request->get('visitors') as $visitorData) {
            $visitor = $this->visitorsRepository->find($visitorData[WorkShiftVisitorContract::FIELD_ID]);
            if ($visitor) {
                $visitor->{WorkShiftVisitorContract::FIELD_TOTAL} = $visitorData[WorkShiftVisitorContract::FIELD_TOTAL];
                $visitor->save();
            }
        }

        $workShift = $this->workShiftRepo->find($request->get('workshift_id'));
        $stats = WorkShiftHelper::recalculateStats($workShift);

        return response()->json([
            'agenda' => $stats['agenda'],
            'errors' => $stats['errors'],
        ]);
    }
}
