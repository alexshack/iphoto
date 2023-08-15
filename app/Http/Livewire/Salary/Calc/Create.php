<?php

namespace App\Http\Livewire\Salary\Calc;

use App\Contracts\Salary\CalcsContract;
use App\Contracts\UserRoleContract;
use App\Models\Salary\Calc;
use App\Repositories\Interfaces\CalcsTypeRepositoryInterface;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use Auth;
use Livewire\Component;

class Create extends Component
{
    public $calc = [];
    public $calcTypes = [];
    public $cities = [];
    public $managers = [];
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
        foreach (CalcsContract::RULES as $key => $rule) {
            $rules["calc.$key"] = $rule;
        }
        return $rules;
    }

    protected function getValidationAttributes() {
        $attributes = [];
        foreach (CalcsContract::ATTRIBUTES as $key => $attr) {
            $attributes["calc.$key"] = $attr;
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
        $this->calc = collect(CalcsContract::FILLABLE_FIELDS)->flip()->map(function ($item) {
            return '';
        })->toArray();
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
            if (!$this->calc[CalcsContract::FIELD_CITY_ID]) {
                $this->places = $this->placeRepository->getAll();
            } else {
                $this->places = $this->placeRepository->getByCityId($this->calc[CalcsContract::FIELD_CITY_ID]);
            }
        }
        $this->managers = $this->userRepository->getCalcsAvailable([
            'city_id' => $this->calc['city_id'],
        ]);
        return view('livewire.salary.calc.create');
    }

    public function submit() {
        $this->validate();
        $this->calc['type'] = 1;
        $this->calc['agent_id'] = Auth::user()->id;
        $calc = Calc::create($this->calc);
        if ($calc) {
            session()->flash('message', 'Начисление создано');
        }
        return redirect()
            ->route('admin.salary.calc.index');
    }

    public function update($name, $value) {
        $this->loadSelect2();
    }
}
