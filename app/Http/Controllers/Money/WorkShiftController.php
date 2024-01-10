<?php

namespace App\Http\Controllers\Money;

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

class WorkShiftController extends Controller
{
    private WorkShiftRepositoryInterface $workshiftRepository;
    private IAccessManager $accessManager;

    public function __construct(
        WorkShiftRepositoryInterface $workshiftRepository,
        IAccessManager $accessManager
    ) {
        $this->workshiftRepository = $workshiftRepository;
        $this->accessManager = $accessManager;
    }

    public function accessReview(WorkShift $workshift) {
        $closable = false;
        $cancelable = false;
        $user = Auth::user();
        $isEmployee = $workshift->employees->first(function ($employee) use ($user) {
            return $employee->user_id = $user->id;
        });
        $nextWorkshift = $this->workshiftRepository->getNext($workshift);

        if ($user->role->{UserRoleContract::FIELD_SLUG} === UserRoleContract::ADMIN_SLUG) {
            $closable = true;
        }

        if ($workshift->{WorkShiftContract::FIELD_CLOSED} &&
            ($user->role->{UserRoleContract::FIELD_SLUG} === UserRoleContract::ADMIN_SLUG || $isEmployee) &&
            ($nextWorkshift && !$nextWorkshift->{WorkShiftContract::FIELD_CLOSED})
            ) {
            $cancelable = true;
        }
        return compact('cancelable', 'closable');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cityId = $request->query(UserWorkDataContract::FIELD_CITY_ID);
        $access = $this->accessManager->checkFieldsAccess([
            UserWorkDataContract::FIELD_CITY_ID => $cityId,
        ]);
        if (!$access) {
            abort(403, 'Доступ запрещен!');
        }

        $filter = [
            'month' => date('m'),
            'year' => date('Y')
        ];
        $period = null;
        if($request->query('filter')) {
            $filter = Helper::dateFilterFormat($request->query('filter'));
            $period = $request->query('filter');
        } else {
            $month = Helper::getMonthName((int)date('m'));
            $year = date('Y');
            $period = "$month $year";
        }

        $filter['city_id'] = $cityId;
        $workshifts = $this->workshiftRepository->getByFilter($filter);

        return view('money.days', compact('workshifts', 'period'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $workshift = $this->workshiftRepository->find($id);
        //dump($workshift);
        //dd(json_encode($workshift));
        $agenda = WorkShiftHelper::recalculateStats($workshift);
        $title = $workshift->title;
        return view('money.day', compact('agenda', 'title', 'workshift'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $workshift = $this->workshiftRepository->find($id);
        $data = WorkShiftHelper::recalculateStats($workshift);
        $data['access'] = $this->accessReview($workshift);
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
