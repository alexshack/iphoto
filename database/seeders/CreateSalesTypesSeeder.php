<?php

namespace Database\Seeders;

use App\Contracts\Money\SalesTypeContract;
use App\Models\Money\SalesType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateSalesTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Добавление демо видов продаж если таблица пустая
        if(SalesType::all()->count() == 0) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            SalesType::insert(SalesTypeContract::DEMO_DATA);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
