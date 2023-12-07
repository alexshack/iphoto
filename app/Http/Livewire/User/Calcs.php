<?php

namespace App\Http\Livewire\User;

use App\Contracts\Salary\CalcsContract;
use App\Contracts\UserContract;
use App\Helpers\Helper;
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

    public $listeners = [
        'onChangeMonth',
    ];

    public $filterData = [];

    public $filterDate = '';

    public function onChangeMonth($month, $year) {
        $this->filterData['year'] = $year;
        $this->filterData['month'] = $month;
        $monthName = Helper::getMonthName($month);
        $this->filterDate = "{$monthName} {$year}";
    }

    public function render(CalcsRepositoryInterface $calcsRepository)
    {
        $this->calcsRepository = $calcsRepository;
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
