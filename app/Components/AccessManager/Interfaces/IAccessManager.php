<?php namespace App\Components\AccessManager\Interfaces;

interface IAccessManager
{
    const FULL_ACCESS = '*';
    const COMMON_ROUTES = [
        'home',
        'admin.home',
        'auth.logout',
    ]; 

    const COMPARE_WITH = 1;

    const ROUTE_PLACES = 1;
    const WILDCARDS = [
        self::ROUTE_PLACES => 'admin.structure.places.*',
    ];

    public function checkRouteAccess($route, $roleSlug = null, $routeParams = null);
    public function checkFieldsAccess(array $fields, $roleSlug = null);
}
