<?php

namespace App\Http\Controllers\Salary;

use App\Contracts\Salary\PaysContract;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PaysRepositoryInterface;
use Illuminate\Http\Request;

class PayController extends Controller
{
    private PaysRepositoryInterface $paysRepositiry;

    public function __construct(PaysRepositoryInterface $paysRepositiry) {
        $this->paysRepository = $paysRepositiry;
    }

    public function index(Request $request) {
        $filter = [
            'month' => date('m'),
            'year' => date('Y')
        ];
        if(request()->query('filter')) {
            $filter = Helper::dateFilterFormat(request()->query('filter'));
        }
        $pays = $this->paysRepository->getByFilter($filter);
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
