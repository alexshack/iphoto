<?php

namespace App\Http\Controllers\Money;

use App\Components\AccessManager\Interfaces\IAccessManager;
use App\Contracts\Money\MovesContract;
use App\Contracts\UserWorkDataContract;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\MovesRepositoryInterface;
use Illuminate\Http\Request;

class MovesController extends Controller
{
    private MovesRepositoryInterface $movesRepository;
    private IAccessManager $accessManager;

    public function __construct(
        MovesRepositoryInterface $movesRepository,
        IAccessManager $accessManager
    ) {
        $this->movesRepository = $movesRepository;
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

        $moves = $this->movesRepository->getByFilter($filter);
        return view('money.moves', compact('moves'));
    }

    public function create() {
        return view('money.move');
    }

    public function edit($id) {
        $move = $this->movesRepository->find($id);
        return view('money.move', compact('move'));
    }

    public function store(Request $request) {
        $validator = $request->validate(MovesContract::RULES);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

    }
}
