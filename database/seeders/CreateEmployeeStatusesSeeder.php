<?php

namespace Database\Seeders;

use App\Contracts\Money\IncomesTypeContract;
use App\Contracts\Salary\EmployeeStatusContract;
use App\Models\Money\IncomesType;
use App\Models\Salary\EmployeeStatuses;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateEmployeeStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Добавление демо статусов сотрудников если таблица пустая
        if(EmployeeStatuses::all()->count() == 0) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            EmployeeStatuses::insert(EmployeeStatusContract::DEMO_DATA);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
