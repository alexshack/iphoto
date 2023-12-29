<?php namespace App\Components\AccessManager\Interfaces;

interface IAccessManager
{
    const FULL_ACCESS = '*';
    const COMMON_ROUTES = [
        'home',
        'admin.home',
        'auth.logout',
    ];

    public function checkRouteAccess($route, $roleSlug = null);
}
