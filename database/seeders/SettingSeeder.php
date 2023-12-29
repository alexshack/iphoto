<?php

namespace Database\Seeders;

use App\Contracts\SettingContract;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = config('app_settings.default_settings');
        foreach ($settings as $settingData) {
            $setting = Setting::where(SettingContract::FIELD_NAME, $settingData[SettingContract::FIELD_NAME])->first();
            if (!$setting) {
                Setting::create($settingData);
            }
        }
    }
}
