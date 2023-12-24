<?php namespace App\Components\AccessManager;

use App\Components\AccessManager\Interfaces\IAccessManager;
use Illuminate\Support\Facades\Auth;

class AccessManager implements IAccessManager
{
    protected $config;

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function checkRouteAccess($routeName, $roleSlug = null)
    {
        if (!$roleSlug || empty($roleSlug)) {
            $roleSlug = Auth::user()->role->{ \App\Contracts\UserRoleContract::FIELD_SLUG };
        }

        if (!$roleSlug) {
            return false;
        }

        $accessConfig = $this->config['routesAccess'] ?? null;
        if (!$accessConfig) {
            return false;
        }

        $slugAccess = $accessConfig[$roleSlug] ?? null;
        if (!$slugAccess) {
            return false;
        }

        if ($slugAccess === self::FULL_ACCESS) {
            return true;
        }

        return $this->checkSlugRouteAccess($slugAccess, $routeName);
    }

    protected function checkSlugRouteAccess($slugAccess, $routeName)
    {
        if (!is_array($slugAccess)) {
            return fnmatch($slugAccess, $routeName);
        }

        foreach ($slugAccess as $pattern) {
            if (fnmatch($pattern, $routeName)) {
                return true;
            }
        }

        return false;
    }
}
