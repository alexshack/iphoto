<?php

namespace App\Http\Controllers\Salary;

use App\Components\AccessManager\Interfaces\IAccessManager;
use App\Contracts\Salary\CalcsContract;
use App\Contracts\UserWorkDataContract;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CalcsRepositoryInterface;
use Illuminate\Http\Request;

class CalcsController extends Controller
{

    private CalcsRepositoryInterface $calcsRepository;
    private IAccessManager $accessManager;

    public function __construct(
        CalcsRepositoryInterface $calcsRepository,
        IAccessManager $accessManager
    ) {
        $this->calcsRepository = $calcsRepository;
        $this->accessManager = $accessManager;
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
        if($request->query('filter')) {
            $filter = Helper::dateFilterFormat($request->query('filter'));
        }

        $filter['city_id'] = $cityId;
        $calcs = $this->calcsRepository->getByFilter($filter);

        return view('salary.calcs', compact('calcs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('salary.calc');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $calc = $this->calcsRepository->find($id);
        return view('salary.calc', compact('calc'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
