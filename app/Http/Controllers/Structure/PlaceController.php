<?php

namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PlaceCalcRepositoryInterface;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    private PlaceRepositoryInterface $placeRepository;
    private PlaceCalcRepositoryInterface $placeCalcRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository, PlaceCalcRepositoryInterface $placeCalcRepository)
    {
        $this->placeRepository = $placeRepository;
        $placeCalcRepository = $placeCalcRepository;
    }

    public function index()
    {
        $list = $this->placeRepository->getAll();
        return view('structure.places')->with(['list' => $list]);
    }

    public function create()
    {
        return view('structure.place');
    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }
}
