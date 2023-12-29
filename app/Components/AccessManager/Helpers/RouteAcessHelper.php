<?php namespace App\Components\AccessManager\Helpers;

use App\Components\AccessManager\Helpers\RoutesAccess\PlacesAccess;
use App\Components\AccessManager\Interfaces\IAccessManager;

class RouteAcessHelper
{
    public static function checkSlugRouteAccess($slugAccess, $routeName, $routeParams = null)
    {
        if (!is_array($slugAccess)) {
            return fnmatch($slugAccess, $routeName);
        }

        foreach ($slugAccess as $rule) {
            if (is_string($rule)) {
                if (fnmatch($rule, $routeName)) {
                    return true;
                }

                continue;
            }

            if (self::applyRule($rule, $routeName, $routeParams)) {
                return true;
            }
        }

        return false;
    }

    protected static function applyRule($rule, $routeName, $routeParams = null)
    {
        $routeTemplate = $rule[0];
        unset($rule[0]);

        if (!fnmatch($routeTemplate, $routeName)) {
            return false;
        }

        if (empty($rule)) {
            return false;
        }

        $activeRouteType = 0;
        foreach (IAccessManager::WILDCARDS as $routeType => $wildcard) {
            if (fnmatch($wildcard, $routeName)) {
                $activeRouteType = $routeType;
            }
        }

        if (!$activeRouteType) {
            return false;
        }

        switch ($activeRouteType) {
            case IAccessManager::ROUTE_PLACES:
                return PlacesAccess::applyRule($rule, $routeParams);
        }

        return false;
    }
}
