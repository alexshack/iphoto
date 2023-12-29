<?php

namespace App\Http\Livewire\Setting;

use App\Contracts\SettingContract;
use App\Models\Setting;
use Livewire\Component;

class Edit extends Component
{
    public Setting $setting;

    public $modelOptions = [];

    public $models = [];

    public $settingTypes = [];

    public function getRules()
    {
        $rules = [];
        foreach (SettingContract::RULES as $ruleKey => $rule) {
            $rules["setting.$ruleKey"] = $rule;
        }
        return $rules;
    }

    public function render()
    {
        if ($this->setting->{SettingContract::FIELD_TYPE} === 2) {
            $this->modelOptions = $this->setting->getModelValueOptions();
        }
        $this->models = SettingContract::MODELS;
        $this->settingTypes = SettingContract::TYPES_LIST;

        return view('livewire.setting.edit');
    }

    public function submit()
    {
        $this->validate();
        $this->setting->save();
        return redirect()->route('settings.index')
            ->with([
                'message' => 'Настройка обновлена',
            ]);
    }
}
