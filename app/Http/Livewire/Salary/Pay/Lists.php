<?php

namespace App\Http\Livewire\Salary\Pay;

use App\Contracts\SettingContract;
use App\Contracts\Salary\PaysContract;
Use App\Contracts\Service\PaysGeneratorContract;
use App\Contracts\UserContract;
use App\Helpers\Helper;
use App\Jobs\SalaryListsGeneratorJob;
use App\Models\Salary\Pay;
use App\Models\Service\PaysGenerator;
use App\Repositories\Interfaces\PaysGeneratorRepositoryInterface;
use App\Repositories\Interfaces\PaysRepositoryInterface;
use App\Repositories\Interfaces\SettingsRepositoryInterface;
use Auth;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Lists extends Component
{
    use WithPagination;

    protected PaysGeneratorRepositoryInterface $paysGeneratorRepository;
    protected PaysRepositoryInterface $paysRepository;
    protected SettingsRepositoryInterface $settingRepository;

    public $filterData = [];
    public $filterDate = '';
    public $isEmptyLists = false;
    public $isInProcess = false;
    public $listeners = [
        'checkSalaryGenerationProcess' => '$refresh',
        'onChangeMonth',
        'refreshComponent' => '$refresh',
    ];
    public $lists = [];

    public function generatePays()
    {
        $this->isInProcess = true;
    }


    public function issuePayItem($payItemID) {
        $pay = Pay::find($payItemID);
        if ($pay) {
            $pay->{ PaysContract::FIELD_ISSUED } = true;
            $pay->save();
        }
        $this->emit('refreshComponent');
    }
    public function onChangeMonth($month, $year) {
        $this->filterData['billing_year'] = $year;
        $this->filterData['billing_month'] = $month;
        $monthName = Helper::getMonthName($month);
        $this->filterDate = "{$monthName} {$year}";
        $this->emit('refreshComponent');
    }

    public function render(
        PaysGeneratorRepositoryInterface $paysGeneratorRepository,
        PaysRepositoryInterface $paysRepository,
        SettingsRepositoryInterface $settingRepository
    )
    {
        $this->isInProcess = false;
        $this->lists = false;
        $this->isEmptyLists = false;
        $this->paysGeneratorRepository = $paysGeneratorRepository;
        $this->paysRepository = $paysRepository;
        $this->settingRepository = $settingRepository;

        $data = [];

        $year = null;
        $month = null;
        $now = Carbon::now();
        if (isset($this->filterData['billing_month']) && isset($this->filterData['billing_year'])) {
            $month = $this->filterData['billing_month'];
            $year = $this->filterData['billing_year'];
        } else {
            $deltaTime = $now->subMonth();
            $month = $deltaTime->month;
            $year = $deltaTime->year;
            $monthName = Helper::getMonthName($month);
            $this->filterDate = "{$monthName} {$year}";
        }

        $filterData = [
            'billing_month' => $month,
            'billing_year' => $year,
            'type' => 1,
        ];

        $pays = $this->paysRepository->getForLists($filterData, true);
        $this->lists = [];
        if ($pays->total() === 0) {
            $this->isEmptyLists = true;
        } else {
            $this->isEmptyLists = false;
            $salary10 = $this->settingRepository->get('salary_10');
            $salary10Option = $salary10 && $salary10->{SettingContract::FIELD_VALUE} ? $salary10->{SettingContract::FIELD_VALUE} : null;
            $salary25 = $this->settingRepository->get('salary_25');
            $salary25Option = $salary25 && $salary25->{SettingContract::FIELD_VALUE} ? $salary25->{SettingContract::FIELD_VALUE} : null;

            $filterData10 = array_merge($filterData, ['calcType' => $salary10Option]);
            $data['salary10'] = $this->paysRepository->getForLists($filterData10, 40);

            $filterData25 = array_merge($filterData, ['calcType' => $salary25Option]);
            $data['salary25'] = $this->paysRepository->getForLists($filterData25, 40);
        }

        $generator = $this->paysGeneratorRepository->get($month, $year);
        if (!$generator && $this->isEmptyLists) {
            $generator = PaysGenerator::create([
                PaysGeneratorContract::FIELD_MONTH => $month,
                PaysGeneratorContract::FIELD_YEAR => $year,
                PaysGeneratorContract::FIELD_USER_ID => Auth::user()->{UserContract::FIELD_ID},
            ]);
            SalaryListsGeneratorJob::dispatch($generator);
        }
        if (!$generator->{PaysGeneratorContract::FIELD_COMPLETED_AT}) {
            $this->isInProcess = true;
        } else {
            if ($month != $now->month || $year != $now->year) {
                $this->lists = [
                    '10-го' => asset("storage/salary-excel-files/$year/$month/salary_10.xlsx"),
                    '25-го' => asset("storage//salary-excel-files/$year/$month/salary_25.xlsx"),
                ];
            }
        }
        $data['generator'] = $generator;

        return view('livewire.salary.pay.lists', compact('data'));
    }
}
