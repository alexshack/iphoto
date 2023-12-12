<?php

namespace App\Repositories;

use App\Contracts\SettingContract;
use App\Models\Setting;
use App\Repositories\Interfaces\SettingsRepositoryInterface;

class SettingsRepository implements SettingsRepositoryInterface
{

    public function all()
    {
        return Setting::all();
    }

    public function find($id)
    {
        return Setting::find($id);
    }

    public function get($name)
    {
        return Setting::where(SettingContract::FIELD_NAME, $name)
            ->first();
    }
}
