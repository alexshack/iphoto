<?php namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class WidgetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('widget', function ($name) {
            return "<?= app('widget')->show($name); ?>";
        });
    }

    public function register()
    {
        App::singleton('widget', function(){
            return new \App\Widgets\Widget;
        });
    }
}
