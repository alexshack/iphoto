<?php

namespace App\Http\Controllers\Structure;

use App\Components\AccessManager\Interfaces\IAccessManager;
use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Contracts\UserWorkDataContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Structure\CreatePlaceRequest;
use App\Http\Requests\Structure\UpdatePlaceRequest;
use App\Models\Structure\Place;
use App\Repositories\Interfaces\CalcsTypeRepositoryInterface;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\PlaceCalcRepositoryInterface;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    private PlaceRepositoryInterface $placeRepository;
    private PlaceCalcRepositoryInterface $placeCalcRepository;
    private CityRepositoryInterface $cityRepository;
    private CalcsTypeRepositoryInterface $calcsTypeRepository;
    private IAccessManager $accessManager;

    public function __construct(
        PlaceRepositoryInterface $placeRepository,
        PlaceCalcRepositoryInterface $placeCalcRepository,
        CityRepositoryInterface $cityRepository,
        CalcsTypeRepositoryInterface $calcsTypeRepository,
        IAccessManager $accessManager
    ) {
        $this->placeRepository = $placeRepository;
        $this->placeCalcRepository = $placeCalcRepository;
        $this->cityRepository = $cityRepository;
        $this->calcsTypeRepository = $calcsTypeRepository;
        $this->accessManager = $accessManager;
    }

    public function index(Request $request)
    {
        $cityId = $request->query(UserWorkDataContract::FIELD_CITY_ID);
        $access = $this->accessManager->checkFieldsAccess([
            UserWorkDataContract::FIELD_CITY_ID => $cityId,
        ]);
        if (!$access) {
            abort(403, 'Доступ запрещен!');
        }

        $list = [];
        if ($cityId) {
            $list = $this->placeRepository->getByCityId($cityId);
        } else {
            $list = $this->placeRepository->getAll();
        }
        
        return view('structure.places')->with(['list' => $list]);
    }

    public function create()
    {
        $cities = $this->cityRepository->getAll();
        return view('structure.place')->with(['cities' => $cities]);
    }

    public function store(CreatePlaceRequest $request)
    {
        $data = $request->validated();
        try {
            $data[ PlaceContract::FIELD_OPENING_DATE ] = (isset($data[ PlaceContract::FIELD_OPENING_DATE ])) ? date('Y-m-d H:i:s', strtotime($data[ PlaceContract::FIELD_OPENING_DATE ])) : null;
            $place = Place::create($data);
            return redirect()->to(route('admin.structure.places.edit', ['id' => $place->{ PlaceContract::FIELD_ID }]))->with('message', 'Точка успешно добавлена!');
        } catch (\Exception $e)  {
            return back()->withErrors(['error' => 'Ошибка базы данных!']);
        }
    }

    public function edit($id)
    {
        $place = Place::findOrFail($id);
        $cities = $this->cityRepository->getAll();
        $placeCalcs = $this->placeCalcRepository->getByPlaceId($id);
        $calcTypes = $this->calcsTypeRepository->getAllAutomaticCalculation();
        return view('structure.place')->with(['place' => $place, 'cities' => $cities, 'placeCalcs' => $placeCalcs, 'calcTypes' => $calcTypes]);
    }

    public function update(UpdatePlaceRequest $request, $id)
    {
        $data = $request->validated();
        try {
            $place = Place::findOrFail($id);
            $data[ PlaceContract::FIELD_OPENING_DATE ] = (isset($data[ PlaceContract::FIELD_OPENING_DATE ])) ? date('Y-m-d H:i:s', strtotime($data[ PlaceContract::FIELD_OPENING_DATE ])) : null;
            $place->update($data);
            return back()->with('message', 'Точка успешно отредактирована!');
        } catch (\Exception $e)  {
            return back()->withErrors(['error' => 'Ошибка базы данных!']);
        }
    }
}
