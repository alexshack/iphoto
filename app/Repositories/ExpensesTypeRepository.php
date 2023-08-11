<?php

namespace App\Repositories;

use App\Models\Money\ExpensesType;
use App\Repositories\Interfaces\ExpensesTypeRepositoryInterface;
use Auth;
use Illuminate\Database\Eloquent\Collection;

class ExpensesTypeRepository implements ExpensesTypeRepositoryInterface
{
    public function getActive(): Collection {
        $user = Auth::user();
        return ExpensesType::where('status', 1)
            ->whereHas('roles', function ($q) use ($user) {
                $q->where('role_id', $user->role_id);
            })
            ->get();
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return ExpensesType::all();
    }
}
