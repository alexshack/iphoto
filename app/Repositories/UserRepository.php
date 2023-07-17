<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\Contracts\UserPersonalDataContract;
use App\Contracts\UserRoleContract;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return User::all();
    }

    /**
     * @param  string  $slug
     * @return array
     */
    public function getByRoleSlug(string $slug): Array
    {
        return Role::where(UserRoleContract::FIELD_SLUG, '=', $slug)->firstOrFail()->users->all();
    }

    public function getMaleCountByRoleSlug(string $slug)
    {
        $role_id = Role::where(UserRoleContract::FIELD_SLUG, '=', $slug)
            ->firstOrFail()->{ UserRoleContract::FIELD_ID };

        return $this->getGenderCountByRoleId(1, $role_id);
    }

    public function getFemaleCountByRoleSlug(string $slug)
    {
        $role_id = Role::where(UserRoleContract::FIELD_SLUG, '=', $slug)
            ->firstOrFail()->{ UserRoleContract::FIELD_ID };

        return $this->getGenderCountByRoleId(2, $role_id);
    }

    private function getGenderCountByRoleId(int $gender, int $role_id):int
    {
        return User::where(UserContract::FIELD_ROLE_ID, '=', $role_id)
            ->whereHas('personalData', function($query) use ($gender){
                $query->where(UserPersonalDataContract::FIELD_GENDER, $gender);
            })->count();
    }
}
