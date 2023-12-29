<?php namespace App\Components\AccessManager;

use App\Components\AccessManager\Helpers\RouteAcessHelper;
use App\Components\AccessManager\Interfaces\IAccessManager;
use App\Contracts\UserWorkDataContract;
use Illuminate\Support\Facades\Auth;

class AccessManager implements IAccessManager
{
    protected $config;

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function checkRouteAccess($routeName, $roleSlug = null, $routeParams = null)
    {
        $slugAccess = $this->getSlugAccess($roleSlug);
        if (!$slugAccess) {
            return false;
        }

        if ($slugAccess === self::FULL_ACCESS) {
            return true;
        }

        return RouteAcessHelper::checkSlugRouteAccess($slugAccess, $routeName, $routeParams);
    }

    public function checkFieldsAccess(array $fields, $roleSlug = null)
    {
        $slugAccess = $this->getSlugAccess($roleSlug);
        if (!$slugAccess) {
            return false;
        }

        if ($slugAccess === self::FULL_ACCESS) {
            return true;
        }

        $access = true;
        foreach ($fields as $fieldName => $fieldValue) {
            switch ($fieldName) {
                case UserWorkDataContract::FIELD_CITY_ID:
                    $cityId = Auth::user()->getWorkData()->city_id;
                    $access = $fieldValue == $cityId;
                    break;
                default:
                    $access = false;
                    break;
            }

            if (!$access) {
                return false;
            }
        }

        return $access;
    }

    protected function getSlugAccess($roleSlug = null)
    {
        if (!$roleSlug || empty($roleSlug)) {
            $roleSlug = Auth::user()->role->{ \App\Contracts\UserRoleContract::FIELD_SLUG };
        }

        if (!$roleSlug) {
            return null;
        }

        $accessConfig = $this->config['routesAccess'] ?? null;
        if (!$accessConfig) {
            return null;
        }

        return $accessConfig[$roleSlug] ?? null;
    }
}
