<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\Contracts\UserPersonalDataContract;
use App\Contracts\UserRoleContract;
use App\Contracts\UserWorkDataContract;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Auth;
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

    public function getCountByRoleSlug(string $slug)
    {
        $role = Role::where(UserRoleContract::FIELD_SLUG, '=', $slug)->firstOrFail();
        return count($role->users);
    }

    public function getByCity(int $cityID)
    {
        return User::whereHas('workData', function ($query) use ($cityID) {
            return $query->where(UserWorkDataContract::FIELD_CITY_ID, $cityID);
        })->with('personalData:id,user_id,last_name,first_name,middle_name')
            ->get();
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
            })
            ->with('personalData:id,user_id,last_name,first_name,middle_name')
            ->get();
    }

    public function getExpenseAvailable() {
        $user = Auth::user();
        $users = [];
        if ($user->role->slug === UserRoleContract::ADMIN_SLUG) {
            $users = $this->getActiveManagers();
        } elseif ($user->role->slug === UserRoleContract::MANAGER_SLUG) {
            $users = [$user];
        }
        return $users;
    }

    public function getCalcsAvailable($data = []) {
        $users = User::where(function ($query) use ($data) {
            if (isset($data['city_id']) && $data['city_id']) {
                $query->whereHas('workData', function ($q) use ($data) {
                    $q->where('city_id', $data['city_id']);
                });
            }
            return $query;
        })->get();
        return $users;
    }
}
