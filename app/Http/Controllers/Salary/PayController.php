<?php

namespace App\Http\Controllers\Salary;

use App\Components\AccessManager\Interfaces\IAccessManager;
use App\Contracts\Salary\PaysContract;
use App\Contracts\UserWorkDataContract;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PaysRepositoryInterface;
use Illuminate\Http\Request;

class PayController extends Controller
{
    private PaysRepositoryInterface $paysRepository;
    private IAccessManager $accessManager;

    public function __construct(
        PaysRepositoryInterface $paysRepositiry,
        IAccessManager $accessManager
    ) {
        $this->paysRepository = $paysRepositiry;
        $this->accessManager = $accessManager;
    }

    public function index(Request $request) {
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
        $pays = $this->paysRepository->getByFilter($filter, 100);

        return view('salary.pays', compact('pays'));
    }

    public function create() {
        return view('salary.pay');
    }

    public function edit(Request $request, $id) {
        $pay = $this->paysRepository->find($id);
        return view('salary.pay', compact('pay'));
    }

    public function payLists()
    {
        return view('salary.pay-lists');
    }
}
