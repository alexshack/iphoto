<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Contracts\UserRoleContract;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::withTrashed()->forceDelete();
        Role::insert(UserRoleContract::ROLE_LIST);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
