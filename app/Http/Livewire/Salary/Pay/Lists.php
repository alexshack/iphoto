<?php

namespace App\Http\Livewire\Salary\Pay;

use App\Repositories\Interfaces\PaysRepositoryInterface;
use App\Repositories\Interfaces\SettingsRepositoryInterface;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Lists extends Component
{
    use WithPagination;

    protected PaysRepositoryInterface $paysRepository;
    protected SettingsRepositoryInterface $settingRepository;

    public $filterData = [];
    public $isEmptyLists = false;
    public $isInProcess = false;

    public function generatePays()
    {
        $this->isInProcess = true;
    }

    public function render(
        PaysRepositoryInterface $paysRepository,
        SettingsRepositoryInterface $settingRepository
    )
    {
        $this->paysRepository = $paysRepository;
        $this->settingRepository = $settingRepository;

        $data = [];

        $now = Carbon::now();
        $deltaTime = $now->subMonth();
        $filterData = [
            'billing_month' => $deltaTime->month,
            'billing_year' => $deltaTime->year,
            'type' => 1,
        ];

        $pays = $this->paysRepository->getForLists($filterData, true);
        if ($pays->total() === 0) {
            $this->isEmptyLists = true;
        } else {
            $salary10 = $this->settingRepository->get('salary_10');
            $salary10Option = $salary10 && $salary10->{SettingContract::FIELD_VALUE} ? $salary10->{SettingContract::FIELD_VALUE} : null;
            $salary25 = $this->settingRepository->get('salary_25');
            $salary25Option = $salary25 && $salary25->{SettingContract::FIELD_VALUE} ? $salary25->{SettingContract::FIELD_VALUE} : null;

            $filterData10 = array_merge($filterData, ['calcType' => $salary10Option]);
            $data['salary10'] = $this->paysRepository->getForLists($filterData10, 40);

            $filterData25 = array_merge($filterData, ['calcType' => $salary25Option]);
            $data['salary25'] = $this->paysRepository->getForLists($filterData25, 40);
        }

        return view('livewire.salary.pay.lists', compact('data'));
    }
}
