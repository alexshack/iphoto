<?php namespace App\Components\AccessManager\Interfaces;

interface IAccessManager
{
    const FULL_ACCESS = '*';
    const COMMON_ROUTES = [
        'home',
        'admin.home',
        'auth.logout',
    ];

    const WORKSHIFT_ROUTES = [
        'workshift.*',
    ];

    const COMPARE_WITH = 1;

    const ROUTE_PLACES = 1;
    const ROUTE_MANAGERS = 2;
    const ROUTE_EMPLOYEES = 3;
    const WILDCARDS = [
        self::ROUTE_PLACES => 'admin.structure.places.*',
        self::ROUTE_MANAGERS => 'admin.structure.managers.*',
        self::ROUTE_EMPLOYEES => 'admin.structure.employees.*',
    ];

    public function checkRouteAccess($route, $roleSlug = null, $routeParams = null);
    public function checkFieldsAccess(array $fields, $roleSlug = null);
}
