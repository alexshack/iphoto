<?php

namespace App\Http\Livewire\User;

use App\Contracts\Salary\CalcsContract;
use App\Contracts\Salary\CalcsTypeContract;
use App\Contracts\UserContract;
use App\Helpers\Helper;
use App\Models\User;
use App\Repositories\Interfaces\CalcsRepositoryInterface;
use App\Repositories\Interfaces\CalcsTypeRepositoryInterface;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Calcs extends Component
{
    use WithPagination;

    private CalcsRepositoryInterface $calcsRepository;
    private CalcsTypeRepositoryInterface $calcsTypeRepository;

    public User $user;

    public $listeners = [
        'onChangeMonth',
    ];

    public $calcTypes = [];

    public $filterData = [];

    public $filterDate = '';

    public function onChangeMonth($month, $year) {
        $this->filterData['year'] = $year;
        $this->filterData['month'] = $month;
        $monthName = Helper::getMonthName($month);
        $this->filterDate = "{$monthName} {$year}";
    }

    public function render(
        CalcsRepositoryInterface $calcsRepository,
        CalcsTypeRepositoryInterface $calcsTypeRepository
    )
    {
        $this->calcsRepository = $calcsRepository;
        $this->calcsTypeRepository = $calcsTypeRepository;

        $calcs = $this->calcsRepository->getByUserID($this->user->{UserContract::FIELD_ID}, $this->filterData);

        $calcTypes = $this->calcsTypeRepository->getByIDs($calcs['ids']);
        foreach ($calcTypes as $calcType) {
            $this->calcTypes[$calcType->{CalcsTypeContract::FIELD_ID}] = $calcType->{CalcsTypeContract::FIELD_NAME};
        }

        return view('livewire.user.calcs', [
            'total' => $calcs['total'],
            'calcs' => $calcs['entries'],
        ]);
    }

    public function hydrate()
    {
        $this->emit('updatedComponent');
    }

    public function mounted()
    {
        $this->setInitialFilterData();
    }

    public function setInitialFilterData()
    {
        $this->filterData = [
            'month' => null,
            'year' => null,
            'calc_type_id' => null,
        ];
    }
}
