<?php

namespace App\Repositories;

use App\Contracts\Money\SalesTypeContract;
use App\Contracts\UserContract;
use App\Contracts\UserPersonalDataContract;
use App\Contracts\UserRoleContract;
use App\Models\Money\SalesType;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Interfaces\SalesTypeRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SalesTypeRepository implements SalesTypeRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return SalesType::all();
    }

    public function getActive(): Collection
    {
        return SalesType::where(SalesTypeContract::FIELD_STATUS, 1)
            ->get();
    }
}
