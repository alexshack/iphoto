<?php

namespace Database\Seeders;

use App\Contracts\UserContract;
use App\Contracts\UserPersonalDataContract;
use App\Contracts\UserWorkDataContract;
use App\Models\User;
use Faker\Provider\Text;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator;

class CreateDemoUsersSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = app(Generator::class);
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createDemoByRole(1, 20);
        $this->createDemoByRole(2, 20);
        $this->createDemoByRole(3, 20);
        $this->createDemoByRole(4, 20);
        $this->createDemoByRole(5, 20);
    }

    public function createDemoByRole(int $role_id, int $count = 10)
    {
        for($i = 0; $i < $count; $i++) {
            $user = new User();
            $user->{ UserContract::FIELD_EMAIL } = $this->faker->unique()->safeEmail;
            $user->{ UserContract::FIELD_PASSWORD } = config('admin.demo_admin_password');
            $user->{ UserContract::FIELD_PHOTO } = '/assets/images/users/admin.webp';
            $user->{ UserContract::FIELD_ROLE_ID } = $role_id;
            $user->save();
            $user->personalData()
                ->first()
                ->update([
                    UserPersonalDataContract::FIELD_LAST_NAME  => $this->faker->lastName,
                    UserPersonalDataContract::FIELD_FIRST_NAME  => $this->faker->firstName,
                    UserPersonalDataContract::FIELD_PHONE  => $this->faker->phoneNumber,
                    UserPersonalDataContract::FIELD_PHONE_ADDITIONAL  => $this->faker->phoneNumber,
                    UserPersonalDataContract::FIELD_EMAIL => $user->{ UserContract::FIELD_EMAIL },
                    UserPersonalDataContract::FIELD_MARITAL_STATUS => rand(1, 3),
                    UserPersonalDataContract::FIELD_GENDER => rand(1, 2),
                    UserPersonalDataContract::FIELD_ADDRESS => $this->faker->address,
                    UserPersonalDataContract::FIELD_REGISTERED_ADDRESS => $this->faker->address,
                ]);
            $user->workData()
                ->first()
                ->update([
                    UserWorkDataContract::FIELD_CITY_ID => rand(1, 2),
                    UserWorkDataContract::FIELD_STATUS => rand(1, 5),
                    UserWorkDataContract::FIELD_POSITION_ID => rand(1, 2)
                ]);
        }
    }
}
