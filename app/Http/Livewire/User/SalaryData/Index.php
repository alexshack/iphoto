<?php

namespace App\Http\Livewire\User\SalaryData;

use App\Contracts\Salary\CalcsTypeContract;
use App\Contracts\PositionContract;
use App\Contracts\UserSalaryDataContract;
use App\Models\User;
use App\Models\UserSalaryData;
use Auth;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = [
        'deleteSalaryData',
        'submitted' => '$refresh',
    ];

    public $typesList = [];

    public User $user;

    public $isEditable = false;

    public function mount()
    {
        if (Auth::user()->role_id === 6) {
            $this->isEditable = true;
        }
    }

    public function render()
    {
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
        return view('livewire.user.salary-data.index');
    }

    public function deleteSalaryData($id) {
        if (!$this->isEditable = false) {
            return;
        }

        $data = UserSalaryData::find($id);
        if ($data) {
            $data->delete();
            $this->emit('$refresh');
        }
    }
}
