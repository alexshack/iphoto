<?php

namespace App\Http\Livewire\User;

use App\Contracts\Salary\CalcsContract;
use App\Contracts\UserContract;
use App\Models\User;
use App\Repositories\Interfaces\CalcsRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;

class Calcs extends Component
{
    use WithPagination;

    private CalcsRepositoryInterface $calcsRepository;

    public User $user;

    public function render(CalcsRepositoryInterface $calcsRepository)
    {
        $this->calcsRepository = $calcsRepository;
        $calcs = $this->calcsRepository->getByUserID($this->user->{UserContract::FIELD_ID});
        return view('livewire.user.calcs', [
            'calcs' => $calcs,
        ]);
    }
}
