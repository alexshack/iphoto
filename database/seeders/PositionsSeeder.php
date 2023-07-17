<?php

namespace Database\Seeders;

use App\Contracts\PositionContract;
use App\Models\Salary\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Position::withTrashed()->forceDelete();
        Position::insert(PositionContract::POSITIONS_LIST);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
