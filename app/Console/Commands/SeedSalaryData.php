<?php

namespace App\Console\Commands;

use App\Contracts\SettingContract;
use App\Models\Setting;
use Illuminate\Console\Command;

class SeedSalaryData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed-salary-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
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
