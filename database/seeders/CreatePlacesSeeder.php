<?php

namespace Database\Seeders;

use App\Contracts\Money\IncomesTypeContract;
use App\Contracts\Salary\EmployeeStatusContract;
use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Models\City;
use App\Models\Money\IncomesType;
use App\Models\Salary\EmployeeStatuses;
use App\Models\Structure\Place;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreatePlacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Добавление демо точки если таблица пустая
        if(Place::all()->count() == 0) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $cities = City::all();
            if(!empty($cities)) {
                foreach ($cities as $city) {
                    $data = PlaceContract::DEMO_DATA;
                    foreach($data as &$item) {
                        $item[ PlaceContract::FIELD_CITY_ID ] = $city->{ CityContract::FIELD_ID };
                    }
                    Place::insert($data);
                }
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
