<?php

namespace Database\Seeders;

use App\Contracts\CityContract;
use App\Contracts\UserRoleContract;
use App\Models\City;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Добавление демо городов если таблица городов пустая
        if(City::all()->count() == 0) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            City::insert(CityContract::DEMO_CITIES_LIST);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
