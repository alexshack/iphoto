<?php

namespace App\Repositories;

use App\Contracts\UserRoleContract;
use App\Contracts\Structure\CityContract;
use App\Models\City;
use App\Repositories\Interfaces\CityRepositoryInterface;
use Auth;
use Illuminate\Database\Eloquent\Collection;

class CityRepository implements CityRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return City::all();
    }

    public function getAvailable(): Collection {
        $user = Auth::user();
        $cities = City::where(function ($query) use ($user) {
            if ($user->role->slug === UserRoleContract::ADMIN_SLUG) {
                return $query;
            }

            if ($user->role->slug === UserRoleContract::MANAGER_SLUG) {
            return $query->whereHas('user', function ($query) use ($user) {
                return $query->where(CityContract::FIELD_MANAGER_ID, $user->id);
            });
            }
        });
        return $cities->get();
    }

    public function getCount() {
        return City::count();
    }
}
