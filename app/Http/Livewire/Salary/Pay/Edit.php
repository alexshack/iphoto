<?php

namespace App\Http\Livewire\Salary\Pay;

use App\Contracts\Salary\CalcsContract;
use App\Contracts\Salary\PaysContract;
use App\Contracts\UserRoleContract;
use App\Helpers\Helper;
use App\Models\Salary\Calc;
use App\Models\Salary\Pay;
use App\Repositories\Interfaces\CalcsTypeRepositoryInterface;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use Auth;
use Livewire\Component;

class Edit extends Component
{
    public $billingMonth;
    public $calcTypes = [];
    public $cities = [];
    public $managers = [];
    public Pay $pay;
    public $places = [];

    protected CityRepositoryInterface $cityRepository;
    protected CalcsTypeRepositoryInterface $calcsTypeRepository;
    protected UserRepositoryInterface $userRepository;
    protected PlaceRepositoryInterface $placeRepository;

    public function changeSelect2() {
        $this->dispatchBrowserEvent('pharaonic.select2.init');
        $this->loadSelect2();
    }

    protected function getRules() {
        $rules = [];
        foreach (PaysContract::RULES as $key => $rule) {
            $rules["pay.$key"] = $rule;
        }
        return $rules;
    }

    protected function getValidationAttributes() {
        $attributes = [];
        foreach (PaysContract::ATTRIBUTES as $key => $attr) {
            $attributes["pay.$key"] = $attr;
        }
        return $attributes;
    }

    public function hydrate() {
        $this->emit('select2Hydrate');
        $this->loadSelect2();
    }

    public function loadSelect2() {
        $ids = [
            '[data-select-init="true"]',
        ];
        foreach ($ids as $id) {
            $this->dispatchBrowserEvent('pharaonic.select2.load', [
                'target'    => $id,
                'component' => $this->id,
            ]);
        }
    }

    public function mount() {
        if ($this->pay) {
            $this->billingMonth = $this->pay->billingMonthHuman;
        }
        //$this->pay->{PaysContract::FIELD_DATE} = $this->pay->{PaysContract::FIELD_DATE}->format('d.m.Y');
        $this->setSourceType('place');
    }

    public function render(
        CalcsTypeRepositoryInterface $calcsTypeRepository,
        CityRepositoryInterface $cityRepository,
        UserRepositoryInterface $userRepository,
        PlaceRepositoryInterface $placeRepository
    )
    {
        $this->calcsTypeRepository = $calcsTypeRepository;
        $this->cityRepository = $cityRepository;
        $this->userRepository = $userRepository;
        $this->placeRepository = $placeRepository;

        $this->calcTypes = $this->calcsTypeRepository->getAllManuallyCalculation();
        $user = Auth::user();
        $this->cities = $this->cityRepository->getAvailable();
        if ($user->role->slug === UserRoleContract::ADMIN_SLUG) {
            if (!$this->pay[PaysContract::FIELD_CITY_ID]) {
                $this->places = $this->placeRepository->getAll();
            } else {
                $this->places = $this->placeRepository->getByCityId($this->pay[PaysContract::FIELD_CITY_ID]);
            }
        }
        $this->managers = $this->userRepository->getCalcsAvailable([
            'city_id' => $this->pay['city_id'],
        ]);
        return view('livewire.salary.pay.edit');
    }

    public function setBillingMonth() {
        if(!$this->billingMonth) {
            return;
        }
        $date = Helper::dateFilterFormat($this->billingMonth);
        $this->pay[PaysContract::FIELD_BILLING_MONTH] = "{$date['year']}-{$date['month']}-01";
    }

    public function setSourceType($type) {
        $this->pay[PaysContract::FIELD_SOURCE_TYPE] = $type;
    }

    public function submit() {
        $this->validate();
        $this->pay['type'] = 1;
        $this->setBillingMonth();
        $this->pay[PaysContract::FIELD_SOURCE_TYPE] = PaysContract::SOURCE_TYPES[$this->pay[PaysContract::FIELD_SOURCE_TYPE]];
        if (!$this->pay[PaysContract::FIELD_ISSUED]) {
            $this->pay[PaysContract::FIELD_ISSUED] = false;
        }
        $this->pay->save();
        if ($this->pay) {
            session()->flash('message', 'Выплата обновлена');
        }
        return redirect()->route('admin.salary.pay.index');
    }

    public function updated($name, $value) {
        //$this->loadSelect2();
        $this->setBillingMonth();
    }
}
