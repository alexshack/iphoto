<?php

namespace App\Http\Livewire\Money;

use App\Contracts\Money\IncomeContract;
use App\Contracts\Structure\CityContract;
use App\Models\City;
use App\Models\Money\Income;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\IncomesTypeRepositoryInterface;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Livewire\Component;

class IncomeForm extends Component
{
    protected IncomesTypeRepositoryInterface $incomesTypeRepository;
    protected CityRepositoryInterface $cityRepository;
    protected UserRepositoryInterface $userRepository;
    protected PlaceRepositoryInterface $placeRepository;

    protected $rules = IncomeContract::RULES;
    protected $validationAttributes = IncomeContract::ATTRIBUTES;

    public $date;
    public $income_type_id;
    public $city_id;
    public $place_id;
    public $manager_id;
    public $amount;
    public $note;
    public $type = 1;

    public $model;
    public $is_edit = false;

    public function mount(Income $income)
    {
        if(!empty($income->{ IncomeContract::FIELD_ID })) {
            $this->date = date('d.m.Y', strtotime($income->date));
            $this->income_type_id = $income->income_type_id;
            $this->city_id = $income->city_id;
            $this->place_id = $income->place_id;
            $this->manager_id = $income->manager_id;
            $this->amount = $income->amount;
            $this->note = $income->note;
            $this->is_edit = true;
            $this->model = $income;
        }
    }

    public function render(IncomesTypeRepositoryInterface $incomesTypeRepository,
        CityRepositoryInterface $cityRepository,
        UserRepositoryInterface $userRepository,
        PlaceRepositoryInterface $placeRepository)
    {
        $this->incomesTypeRepository = $incomesTypeRepository;
        $this->cityRepository = $cityRepository;
        $this->userRepository = $userRepository;
        $this->placeRepository = $placeRepository;
        $places = [];
        $users = [];
        if($this->city_id) {
            $places = $this->placeRepository->getByCityId($this->city_id);
            $users = City::where('id', '=', $this->city_id)->get();
        }
        return view('livewire.money.income-form')
            ->with([
                'types' => $this->incomesTypeRepository->getAll(),
                'cities' => $this->cityRepository->getAll(),
                'managers' => $this->userRepository->getActiveManagers(),
                'places' => $places,
                'users' => $users
                   ]);
    }

    public function changeType($type)
    {
        $this->type = $type;
    }

    public function hydrate()
    {
        $this->emit('select2Hydrate');
    }

    public function submit()
    {
        $this->validate();

        try {
            if($this->is_edit) {
                $this->edit();
            } else {
                $this->create();
            }
        } catch (\Exception $e)  {
            $this->addError('error', 'Ошиба базы данных!');
        }
    }

    public function create()
    {
        $income = Income::create([
                                     'date' => $this->date,
                                     'income_type_id' => $this->income_type_id,
                                     'city_id' => $this->city_id,
                                     'type' => $this->type,
                                     'place_id' => $this->place_id,
                                     'manager_id' => $this->manager_id,
                                     'amount' => $this->amount,
                                     'note' => $this->note
                                 ]);
        return redirect()->to(route('admin.money.incomes.edit', ['id' => $income->{ IncomeContract::FIELD_ID }]))->with('message', 'Поступление ДС успешно добавлено!');
    }

    public function edit()
    {
        $this->model->update([
                                 'date' => $this->date,
                                 'income_type_id' => $this->income_type_id,
                                 'city_id' => $this->city_id,
                                 'type' => $this->type,
                                 'place_id' => $this->place_id,
                                 'manager_id' => $this->manager_id,
                                 'amount' => $this->amount,
                                 'note' => $this->note
                             ]);
        session()->flash('message', 'Поступление ДС успешно отредактировано!');
    }
}
