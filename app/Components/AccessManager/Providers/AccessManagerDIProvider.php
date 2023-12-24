<?php namespace App\Components\AccessManager\Providers;

use App\Components\AccessManager\AccessManager;
use App\Components\AccessManager\Interfaces\IAccessManager;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AccessManagerDIProvider extends ServiceProvider
{
    public function register()
    {
        App::bind(IAccessManager::class, function (Application $app) {
            $obj = $app->make(AccessManager::class);
            $obj->setConfig(Config::get('components.accessManager'));
            return $obj;
        });
    }
}
