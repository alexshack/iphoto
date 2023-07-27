<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\Contracts\UserPersonalDataContract;
use App\Contracts\UserRoleContract;
use App\Contracts\UserWorkDataContract;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Получение всех пользователей
     * @return Collection
     */
    public function getAll(): Collection
    {
        return User::all();
    }

    /**
     * Получение пользователей по роли
     * @param  string  $slug
     * @return array
     */
    public function getByRoleSlug(string $slug): Array
    {
        return Role::where(UserRoleContract::FIELD_SLUG, '=', $slug)->firstOrFail()->users->all();
    }

    /**
     * Получение количества мужчин по роли
     * @param  string  $slug
     * @return int
     */
    public function getMaleCountByRoleSlug(string $slug)
    {
        $role_id = Role::where(UserRoleContract::FIELD_SLUG, '=', $slug)
            ->firstOrFail()->{ UserRoleContract::FIELD_ID };

        return $this->getGenderCountByRoleId(1, $role_id);
    }

    /**
     * Получение количества женщин по роли
     * @param  string  $slug
     * @return int
     */
    public function getFemaleCountByRoleSlug(string $slug)
    {
        $role_id = Role::where(UserRoleContract::FIELD_SLUG, '=', $slug)
            ->firstOrFail()->{ UserRoleContract::FIELD_ID };

        return $this->getGenderCountByRoleId(2, $role_id);
    }

    /**
     * Получение числа пользователей определенного пола по роли
     * @param  int  $gender
     * @param  int  $role_id
     * @return int
     */
    private function getGenderCountByRoleId(int $gender, int $role_id):int
    {
        return User::where(UserContract::FIELD_ROLE_ID, '=', $role_id)
            ->whereHas('personalData', function($query) use ($gender){
                $query->where(UserPersonalDataContract::FIELD_GENDER, $gender);
            })->count();
    }

    /**
     * Получение списка действующих менеджеров
     * @return mixed
     */
    public function getActiveManagers()
    {
        return Role::where(UserRoleContract::FIELD_SLUG, '=', UserRoleContract::MANAGER_SLUG)
            ->firstOrFail()
            ->users()
            ->whereHas('workData', function($query) {
                $query->whereNotIn(UserWorkDataContract::FIELD_STATUS, UserWorkDataContract::INACTIVE_STATUS_LIST);
            })->get();
    }
}
