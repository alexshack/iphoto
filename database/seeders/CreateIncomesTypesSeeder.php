<?php

namespace Database\Seeders;

use App\Contracts\Money\IncomesTypeContract;
use App\Models\Money\IncomesType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateIncomesTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Добавление демо видов поступлений если таблица пустая
        if(IncomesType::all()->count() == 0) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            IncomesType::insert(IncomesTypeContract::DEMO_DATA);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
