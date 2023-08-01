<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Http\Requests\Money\CreateSalesTypeRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            CitiesSeeder::class,
            PositionsSeeder::class,
            CreatePlacesSeeder::class,
            CreateSalesTypesSeeder::class,
            CreateIncomesTypesSeeder::class,
            CreateExpensesTypesSeeder::class,
            CreateEmployeeStatusesSeeder::class,
            CreateAdminSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
