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

class Edit extends Component
{
    protected ExpensesTypeRepositoryInterface $expensesTypeRepository;

    public $amountLabel = '';
    public $expenseTypes = [];
    public UserSalaryData $salaryData;
    public $typesList = [];
    public $user;

    public function mount()
    {
        $this->user = $this->salaryData->user;
        foreach (CalcsTypeContract::TYPE_LIST as $typeKey => $typeItem) {
            if (!in_array($typeKey, UserSalaryDataContract::TYPES_ALLOWED)) {
                continue;
            }
            if (!isset($typeItem['userSalary'])) {
                continue;
            }
            $type = [
                'label' => $typeItem['name'],
                'columns' => $typeItem['userSalary']['columns'],
                'values' => $this->user->salaryData->filter(function ($item) use ($typeKey) {
                    if ((int) $item->{UserSalaryDataContract::FIELD_CALCS_TYPES_TYPE} === (int) $typeKey) {
                        return true;
                    }

                    return false;
                }),
            ];
            $this->typesList[(int)$typeKey] = $type;
        }
    }

    public function render(ExpensesTypeRepositoryInterface $expensesTypeRepository)
    {
        $this->expensesTypeRepository = $expensesTypeRepository;
        $this->expenseTypes = $this->expensesTypeRepository->getActive();
        if ($this->salaryData->{UserSalaryDataContract::FIELD_CALCS_TYPES_TYPE}) {
            $type = $this->typesList[$this->salaryData->{UserSalaryDataContract::FIELD_CALCS_TYPES_TYPE}];
            if ($type) {
                $this->amountLabel = $type['columns'][UserSalaryDataContract::FIELD_AMOUNT]['attribute'];
            }

        } else {
            $this->amountLabel = 'Сумма';
        }
        return view('livewire.user.salary-data.edit');
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

    public function hydrate() {
        $this->loadFormInputs();
    }

    public function loadFormInputs() {
        $this->emit('inputHydrate');
    }

    public function submit() {
        $validated = $this->validate();
        if (isset($validated['salaryData']) && isset($validated['salaryData'][UserSalaryDataContract::FIELD_CUSTOM_DATA])) {
            $validated['salaryData'][UserSalaryDataContract::FIELD_CUSTOM_DATA] = json_encode($validated['salaryData'][UserSalaryDataContract::FIELD_CUSTOM_DATA]);
        }
        $this->salaryData->save();
        session()->flash('message', 'Расчет обновлен');
        return redirect()->route('admin.structure.employees.edit', [
            'id' => $this->salaryData->{UserSalaryDataContract::FIELD_USER_ID},
        ])->with([
            'message' => session('message'),
        ]);
    }

    public function update($key, $value) {
        $this->loadFormInputs();
    }
}
