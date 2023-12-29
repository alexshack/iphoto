<?php namespace App\Widgets;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class Widget
{
    public function show($widgetName, $data =[]) {
        $configName = implode('.', ['widgets', $widgetName]);
        $widgetClass = Config::get($configName);

        if($widgetClass ?? null){
            $widget = App::make($widgetClass, $data);
            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    if (property_exists($widget, $key)) {
                        $widget->$key = $value;
                    }
                }
            }

            return $widget->execute();
        }
    }
}
