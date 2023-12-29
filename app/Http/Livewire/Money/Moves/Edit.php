<?php

namespace App\Http\Livewire\Money\Moves;

use App\Contracts\Money\MovesContract;
use App\Contracts\UserRoleContract;
use App\Models\Money\Move;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Auth;
use Livewire\Component;

class Edit extends Component
{
    public $cities = [];
    public $managers = [];
    public Move $moveData;
    public $places = [];

    protected CityRepositoryInterface $cityRepository;
    protected UserRepositoryInterface $userRepository;
    protected PlaceRepositoryInterface $placeRepository;

    public function changeSelect2() {
        $this->dispatchBrowserEvent('pharaonic.select2.init');
        $this->loadSelect2();
    }

    protected function getRules() {
        $rules = [];
        foreach (MovesContract::RULES as $key => $rule) {
            $rules["moveData.$key"] = $rule;
        }
        return $rules;
    }

    protected function getValidationAttributes() {
        $attributes = [];
        foreach (MovesContract::ATTRIBUTES as $key => $attr) {
            $attributes["moveData.$key"] = $attr;
        }
        return $attributes;
    }

    public function hydrate() {
        $this->emit('select2Hydrate');
        $this->loadSelect2();
    }

    public function loadSelect2() {
        $ids = [
            '#payerPlace',
            '#payerManager',
            '#recipientPlace',
            '#recipientManager',
        ];
        foreach ($ids as $id) {
            $this->dispatchBrowserEvent('pharaonic.select2.load', [
                'target'    => $id,
                'component' => $this->id,
            ]);
        }
    }

    public function render(
        CityRepositoryInterface $cityRepository,
        UserRepositoryInterface $userRepository,
        PlaceRepositoryInterface $placeRepository
    )
    {
        $this->cityRepository = $cityRepository;
        $this->userRepository = $userRepository;
        $this->placeRepository = $placeRepository;

        $user = Auth::user();
        $this->cities = $this->cityRepository->getAvailable();
        if ($user->role->slug === UserRoleContract::ADMIN_SLUG) {
            if (!$this->moveData[MovesContract::FIELD_CITY_ID]) {
                $this->places = $this->placeRepository->getAll();
            } else {
                $this->places = $this->placeRepository->getByCityId($this->moveData[MovesContract::FIELD_CITY_ID]);
            }
        }
        $this->managers = $this->userRepository->getExpenseAvailable();
        return view('livewire.money.moves.edit');
    }

    public function setPayerType($type){
        if ($this->moveData) {
            $this->moveData[MovesContract::FIELD_PAYER_TYPE] = $type;
            $this->moveData[MovesContract::FIELD_PAYER_ID] = null;
        }
        $this->changeSelect2();
    }

    public function setRecipientType($type) {
        if($this->moveData) {
            $this->moveData[MovesContract::FIELD_RECIPIENT_TYPE] = $type;
            $this->moveData[MovesContract::FIELD_RECIPIENT_ID] = null;
        }
        $this->changeSelect2();
    }

    public function submit() {
        $this->validate();
        $this->moveData->save();
    }

    public function updated($name, $value) {
        $this->dispatchBrowserEvent('pharaonic.select2.init');
    }
}
