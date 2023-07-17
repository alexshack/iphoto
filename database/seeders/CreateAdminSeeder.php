<?php

namespace Database\Seeders;

use App\Contracts\UserContract;
use App\Contracts\UserPersonalDataContract;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $user = User::withTrashed()->where(UserContract::FIELD_EMAIL, '=', config('admin.demo_admin_login'))->first();
        if($user)
            $user->forceDelete();

        User::create([
            UserContract::FIELD_EMAIL => config('admin.demo_admin_login'),
            UserContract::FIELD_PASSWORD => config('admin.demo_admin_password'),
            UserContract::FIELD_PHOTO => '/assets/images/users/admin.webp',
            UserContract::FIELD_ROLE_ID => 6
        ]);

        User::where(UserContract::FIELD_EMAIL, '=', config('admin.demo_admin_login'))
            ->first()
            ->personalData
            ->update([
                UserPersonalDataContract::FIELD_LAST_NAME => 'Admin',
                UserPersonalDataContract::FIELD_FIRST_NAME => 'Admin'
                     ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
