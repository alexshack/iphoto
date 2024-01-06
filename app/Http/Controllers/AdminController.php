<?php

namespace App\Http\Controllers;

use App\Components\AccessManager\Interfaces\IAccessManager;
use App\Contracts\UserRoleContract;
use App\Contracts\UserWorkDataContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Models\WorkShift\WorkShift;
use App\Helpers\Helper;
use App\Helpers\WorkShiftHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private WorkShiftRepositoryInterface $workShiftRepository;
    private IAccessManager $accessManager;

    public function __construct(
        WorkShiftRepositoryInterface $workShiftRepository,
        IAccessManager $accessManager
    ) {
        $this->workShiftRepository = $workShiftRepository;
        $this->accessManager = $accessManager;
    }

    public function index(Request $request) {
        $cityId = $request->query(UserWorkDataContract::FIELD_CITY_ID);
        $filter = [
            'city_id' => $cityId
        ];
        $todayWorkShifts = $this->workShiftRepository->getToday($filter);
        $yesterdayWorkShifts = $this->workShiftRepository->getYesterday($filter);
        return view('admin.index', compact('todayWorkShifts', 'yesterdayWorkShifts'));
    }
}
