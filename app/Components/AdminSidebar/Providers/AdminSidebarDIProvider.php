<?php namespace App\Components\AdminSidebar\Providers;

use App\Components\AdminSidebar\AdminSidebar;
use App\Components\AdminSidebar\Interfaces\IAdminSidebar;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AdminSidebarDIProvider extends ServiceProvider
{
    public function register()
    {
        App::bind(IAdminSidebar::class, AdminSidebar::class);
    }
}
