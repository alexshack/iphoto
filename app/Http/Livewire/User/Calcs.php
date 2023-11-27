<?php

namespace App\Http\Livewire\User;

use App\Contracts\Salary\CalcsContract;
use App\Contracts\UserContract;
use App\Models\User;
use App\Repositories\Interfaces\CalcsRepositoryInterface;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Calcs extends Component
{
    use WithPagination;

    private CalcsRepositoryInterface $calcsRepository;

    public User $user;

    public $filterData = [];

    public $filterDate = '';

    public function render(CalcsRepositoryInterface $calcsRepository)
    {
        $this->calcsRepository = $calcsRepository;
        if ($this->filterDate) {
            $date = Carbon::createFromFormat('m.Y', $this->filterDate);
            $this->filterData = [
                'year' => $date->year,
                'month' => $date->month,
            ];
        }
        $calcs = $this->calcsRepository->getByUserID($this->user->{UserContract::FIELD_ID}, $this->filterData);
        return view('livewire.user.calcs', [
            'total' => $calcs['total'],
            'calcs' => $calcs['entries'],
        ]);
    }

    public function hydrate()
    {
        $this->emit('updatedComponent');
    }
}
