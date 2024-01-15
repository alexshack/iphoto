<?php

namespace App\Http\Controllers\Structure;

use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Structure\CreateCityRequest;
use App\Http\Requests\Structure\UpdateCityRequest;
use App\Models\City;
use App\Repositories\Interfaces\CityManagerRepositoryInterface;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class CityController extends Controller
{
    private CityRepositoryInterface $cityRepository;
    private CityManagerRepositoryInterface $cityManagerRepository;
    private PlaceRepositoryInterface $placeRepository;
    private UserRepositoryInterface $userRepository;
    private $managerList;

    public function __construct(CityRepositoryInterface $cityRepository, CityManagerRepositoryInterface $cityManagerRepository,PlaceRepositoryInterface $placeRepository, UserRepositoryInterface $userRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->cityManagerRepository = $cityManagerRepository;
        $this->placeRepository = $placeRepository;
        $this->userRepository = $userRepository;
        $this->managerList = $this->userRepository->getActiveManagers();
    }

    public function index()
    {
        $list = $this->cityRepository->getAll();
        return view('structure.cities')->with(['list' => $list]);
    }

    public function dashboard($id)
    {
        $city = City::findOrFail($id);
        $list = $this->placeRepository->getByCityId($id);
        $total = $list->sum(PlaceContract::FIELD_CURRENT_BALANCE);
        return view('structure.city-dashboard')->with(compact('city', 'list', 'total'));
    }

    public function edit($id)
    {
        $city = City::findOrFail($id);
        return view('structure.city')
            ->with([
                'city' => $city,
                'managerHistory' => $this->cityManagerRepository->getByCityId($id),
                'managers' => $this->managerList
            ]);
    }

    public function update(UpdateCityRequest $request, $id)
    {
        $data = $request->validated();
        try {
            $city = City::findOrFail($id);
            $city->update($data);
            return back()->with('message', 'Город успешно отредактирован!');
        } catch (\Exception $e)  {
            return back()->withErrors(['error' => 'Ошибка базы данных!']);
        }
    }

    public function create()
    {
        return view('structure.city');
    }

    public function store(CreateCityRequest $request)
    {
        $data = $request->validated();
        try {
            $city = City::create($data);
            return redirect()->to(route('admin.structure.cities.edit', ['id' => $city->{ CityContract::FIELD_ID }]))->with('message', 'Город успешно добавлен!');
        } catch (\Exception $e)  {
            return back()->withErrors(['error' => 'Ошибка базы данных!']);
        }
    }
}
