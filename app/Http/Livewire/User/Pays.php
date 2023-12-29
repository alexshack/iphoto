<?php

namespace App\Http\Livewire\User;

use App\Contracts\UserContract;
use App\Helpers\Helper;
use App\Models\User;
use App\Repositories\Interfaces\PaysRepositoryInterface;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Pays extends Component
{
    use WithPagination;

    private PaysRepositoryInterface $paysRepository;

    public User $user;

    public $listeners = [
        'onChangeMonth',
    ];

    public $filterData = [];

    public $filterDate = '';

    public function mounted() {
    }

    public function onChangeMonth($month, $year) {
        $this->filterData['billing_year'] = $year;
        $this->filterData['billing_month'] = $month;
        $monthName = Helper::getMonthName($month);
        $this->filterDate = "{$monthName} {$year}";
    }

    public function render(PaysRepositoryInterface $paysRepository)
    {
        $this->filterData['issued'] = true;
        if (!$this->filterDate) {
            $now = Carbon::now();
            $deltaTime = $now->subMonth();
            $this->filterData['billing_year'] = $deltaTime->year;
            $this->filterData['billing_month'] = $deltaTime->month;
            $monthName = Helper::getMonthName($deltaTime->month);
            $this->filterDate = "{$monthName} {$deltaTime->year}";
        }

        $this->paysRepository = $paysRepository;
        $pays = $this->paysRepository->getByUserID($this->user->{UserContract::FIELD_ID}, $this->filterData);

        return view('livewire.user.pays', [
            'total' => $pays['total'],
            'pays' => $pays['entries'],
        ]);
    }

    public function hydrate()
    {
        $this->emit('updatedComponent');
    }
}
