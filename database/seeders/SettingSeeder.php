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
        $settings = [
            [
                SettingContract::FIELD_TYPE => 2,
                SettingContract::FIELD_NAME => 'salary_10',
                SettingContract::FIELD_MODEL => 'CalcsType',
            ],
            [
                SettingContract::FIELD_TYPE => 2,
                SettingContract::FIELD_NAME => 'salary_25',
                SettingContract::FIELD_MODEL => 'CalcsType',
            ],
            [
                SettingContract::FIELD_TYPE => 2,
                SettingContract::FIELD_NAME => 'last_month_debt',
                SettingContract::FIELD_MODEL => 'CalcsType',
            ],
        ];

        foreach ($settings as $settingData) {
            $setting = Setting::where(SettingContract::FIELD_NAME, $settingData[SettingContract::FIELD_NAME])->first();
            if (!$setting) {
                Setting::create($settingData);
            }
        }
    }
}
