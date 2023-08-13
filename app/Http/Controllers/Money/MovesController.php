<?php

namespace App\Http\Controllers\Money;

use App\Contracts\Money\MovesContract;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\MovesRepositoryInterface;
use Illuminate\Http\Request;

class MovesController extends Controller
{
    private MovesRepositoryInterface $movesRepository;

    public function __construct(MovesRepositoryInterface $movesRepository) {
        $this->movesRepository = $movesRepository;
    }

    public function index() {
        $filter = [
            'month' => date('m'),
            'year' => date('Y')
        ];
        if(request()->query('filter')) {
            $filter = Helper::dateFilterFormat(request()->query('filter'));
        }
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
}
