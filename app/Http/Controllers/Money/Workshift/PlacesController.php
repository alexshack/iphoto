<?php

namespace App\Http\Controllers\Money\Workshift;

use App\Contracts\WorkShift\WorkShiftContract;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use Illuminate\Http\Request;

class PlacesController extends Controller
{
    private PlaceRepositoryInterface $placeRepository;
    private WorkShiftRepositoryInterface $workShiftRepo;

    public function __construct(
        PlaceRepositoryInterface $placeRepository,
        WorkShiftRepositoryInterface $workShiftRepo) {
        $this->workShiftRepo = $workShiftRepo;
        $this->placeRepository = $placeRepository;
    }

    public function getByWorkShiftCity(Request $request) {
        $workShift = $this->workShiftRepo->find($request->get('workshiftID'));
        $places = $this->placeRepository->getByCityId($workShift->{WorkShiftContract::FIELD_CITY_ID});
        return response()->json($places);
    }

}
