<?php

namespace App\Http\Livewire\Money\Expense;

use App\Contracts\Money\ExpenseContract;
use App\Contracts\UserRoleContract;
use App\Models\Money\Expense;
use App\Repositories\Interfaces\ExpensesTypeRepositoryInterface;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $cities = [];
    public $checkFile;
    public Expense $expense;
    public $expenseTypes = [];
    public $managers = [];
    public $payerType = ExpenseContract::TYPE_PLACE;
    public $places = [];

    protected CityRepositoryInterface $cityRepository;
    protected ExpensesTypeRepositoryInterface $expensesTypeRepository;
    protected UserRepositoryInterface $userRepository;
    protected PlaceRepositoryInterface $placeRepository;

    public function changeSelect2() {
        $this->dispatchBrowserEvent('pharaonic.select2.init');
        $this->loadSelect2();
    }

    protected function getRules() {
        $rules = [];
        foreach (ExpenseContract::RULES as $key => $rule) {
            $rules["expense.$key"] = $rule;
        }
        return $rules;
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

    public function render(ExpensesTypeRepositoryInterface $expensesTypeRepository,
        CityRepositoryInterface $cityRepository,
        UserRepositoryInterface $userRepository,
        PlaceRepositoryInterface $placeRepository
    )
    {
        $this->cityRepository = $cityRepository;
        $this->expensesTypeRepository = $expensesTypeRepository;
        $this->userRepository = $userRepository;
        $this->placeRepository = $placeRepository;

        $user = Auth::user();
        $this->expenseTypes = $this->expensesTypeRepository->getActive();
        $this->cities = $this->cityRepository->getAvailable();
        if ($user->role->slug === UserRoleContract::ADMIN_SLUG) {
            if (!$this->expense[ExpenseContract::FIELD_CITY_ID]) {
                $this->places = $this->placeRepository->getAll();
            } else {
                $this->places = $this->placeRepository->getByCityId($this->expense[ExpenseContract::FIELD_CITY_ID]);
            }
        }
        $this->managers = $this->userRepository->getExpenseAvailable();
        return view('livewire.money.expense.edit');
    }

    public function setPayerType($type){
        $this->payerType = $type;
    }

    public function submit() {
        $this->validate();
        $this->expense->type = $this->payerType;
        if ($this->payerType === ExpenseContract::TYPE_PLACE) {
            $this->expense->manager_id = null;
        } elseif ($this->payerType === ExpenseContract::TYPE_MANAGER) {
            $this->expense->place_id = null;
        }
        $this->expense->save();
    }

    public function updatedCheckFile() {
        $this->expense->check_file = $this->checkFile->store('public/check-files');
    }

    public function update($name, $value) {
        $this->changeSelect2();
    }

}
