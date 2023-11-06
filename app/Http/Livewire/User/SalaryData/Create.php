<?php

namespace App\Http\Livewire\User\SalaryData;

use App\Contracts\PositionContract;
use App\Contracts\Salary\CalcsTypeContract;
use App\Contracts\UserContract;
use App\Contracts\UserSalaryDataContract;
use App\Models\User;
use App\Models\UserSalaryData;
use App\Repositories\Interfaces\ExpensesTypeRepositoryInterface;
use Livewire\Component;

class Create extends Component
{
    protected ExpensesTypeRepositoryInterface $expensesTypeRepository;

    public $amountLabel = '';
    public $expenseTypes = [];
    public $salaryData = [
        UserSalaryDataContract::FIELD_CALCS_TYPES_TYPE => null,
        UserSalaryDataContract::FIELD_AMOUNT => 0,
        UserSalaryDataContract::FIELD_USER_ID => null,
    ];
    public $modalShow = false;

    public $typesList = [];
    public User $user;

    public function render(ExpensesTypeRepositoryInterface $expensesTypeRepository)
    {
        $this->salaryData[UserSalaryDataContract::FIELD_USER_ID] = $this->user->{UserContract::FIELD_ID};
        $this->expensesTypeRepository = $expensesTypeRepository;
        $this->expenseTypes = $this->expensesTypeRepository->getActive();
        if ($this->salaryData[UserSalaryDataContract::FIELD_CALCS_TYPES_TYPE]) {
            $type = $this->typesList[$this->salaryData[UserSalaryDataContract::FIELD_CALCS_TYPES_TYPE]];
            if ($type) {
                $this->amountLabel = $type['columns'][UserSalaryDataContract::FIELD_AMOUNT]['attribute'];
            }

        } else {
            $this->amountLabel = 'Сумма';
        }
        return view('livewire.user.salary-data.create');
    }

    protected function getValidationAttributes() {
        $attributes = [];
        foreach (UserSalaryDataContract::ATTRIBUTES as $key => $value) {
            if ($key === UserSalaryDataContract::FIELD_AMOUNT) {
                $value = $this->amountLabel;
            }
            $attributes["salaryData.$key"] = $value;
        }
        return $attributes;
    }

    protected function getRules() {
        $rules = [];
        foreach (UserSalaryDataContract::RULES as $key => $value) {
            $rules["salaryData.$key"] = $value;
        }
        return $rules;
    }

    public function modalOpen() {
        $this->modalShow = true;
        $this->emit('$refresh');
        $this->dispatchBrowserEvent('showCreateModal');
    }

    public function submit() {
        $validated = $this->validate();
        $validated['salaryData'][UserSalaryDataContract::FIELD_CUSTOM_DATA] = json_encode($validated['salaryData'][UserSalaryDataContract::FIELD_CUSTOM_DATA]);
        $salaryData = UserSalaryData::create($validated['salaryData']);
        $this->emitUp('submitted');
        $this->modalShow = false;
        $this->dispatchBrowserEvent('hideCreateModal');
        $this->emit('$refresh');
    }
}
