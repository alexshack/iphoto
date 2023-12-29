<?php

namespace App\Http\Controllers\Structure;

use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\CityManagerContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Structure\CreateCityManagerRequest;
use App\Http\Requests\Structure\UpdateCityManagerRequest;
use App\Models\City;
use App\Models\CityManagerHistory;
use App\Repositories\Interfaces\CityManagerRepositoryInterface;
use Illuminate\Http\Request;

class CityManagerController extends Controller
{
    private CityManagerRepositoryInterface $cityManagerRepository;

    public function __construct(CityManagerRepositoryInterface $cityManagerRepository)
    {
        $this->cityManagerRepository = $cityManagerRepository;
    }

    public function store(CreateCityManagerRequest $request)
    {
        try {
            $cityManager = new CityManagerHistory();
            $cityManager->{ CityManagerContract::FIELD_CITY_ID } = $request->{ CityManagerContract::FIELD_CITY_ID };
            $cityManager->{ CityManagerContract::FIELD_MANAGER_ID } = $request->{ CityManagerContract::FIELD_MANAGER_ID };
            $cityManager->{ CityManagerContract::FIELD_APPOINTMENT_DATE } = date('d-m-Y H:i:s', strtotime($request->{ CityManagerContract::FIELD_APPOINTMENT_DATE }));
            if($cityManager->save()) {
                $this->updateCityManager($request->{ CityManagerContract::FIELD_CITY_ID });
            }
            return response()->json(['message' => 'Success!'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => [
                'error' => $e->getMessage()
            ], 422]);
        }
    }

    public function update(UpdateCityManagerRequest $request, $id)
    {
        try {
            $cityManager = CityManagerHistory::findOrFail($id);
            $cityManager->update($request->only([CityManagerContract::FIELD_MANAGER_ID, CityManagerContract::FIELD_APPOINTMENT_DATE]));
            $this->updateCityManager($cityManager->{ CityManagerContract::FIELD_CITY_ID });
            return response()->json(['message' => 'Success!'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => [
                'error' => $e->getMessage()
            ], 422]);
        }
    }

    private function updateCityManager($cityId)
    {
        $city = City::findOrFail($cityId);
        $city->{ CityContract::FIELD_MANAGER_ID } = $this->cityManagerRepository->getLastManagerByCityId( $cityId )->{ CityManagerContract::FIELD_MANAGER_ID };
        $city->save();
    }

    public function destroy($id)
    {
        try {
            $cityManager = CityManagerHistory::findOrFail($id);
            $cityManager->delete();
            return back()->with('message', 'Менеджер удален!');
        } catch (\Exception $e) {
            return back()->withErrors(['errors' => 'Ошибка базы данных!']);
        }
    }
}
