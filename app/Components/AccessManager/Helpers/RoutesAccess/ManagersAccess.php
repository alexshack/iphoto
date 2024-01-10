<?php namespace App\Components\AccessManager\Helpers\RoutesAccess;

use App\Components\AccessManager\Interfaces\IAccessManager;
use App\Contracts\UserContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ManagersAccess
{
    public static function applyRule($rule, $routeParams = null)
    {
        $access = true;
        foreach ($rule as $ruleId => $ruleField) {
            switch ($ruleId) {
                case IAccessManager::COMPARE_WITH:
                    $access = self::withRule($ruleField, $routeParams);
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

    /* Rules */
    protected static function withRule($fields, $routeParams = null)
    {
        if (!is_array($fields)) {
            $fields = [$fields];
        }

        $access = true;
        foreach ($fields as $fieldName) {
            switch ($fieldName) {
                case UserContract::FIELD_ID:
                    $access = self::checkoutUserId($routeParams);
                    break;
            }

            if (!$access) {
                return false;
            } 
        }

        return $access;
    }

    /* Helpers */
    protected static function checkoutUserId($routeParams = null)
    {
        $userId = Auth::user()->{ UserContract::FIELD_ID };
        if (!$userId) {
            return false;
        }

        $currentRouteParams = Route::current()->parameters();
        $routeUserId = $routeParams['id'] ?? $currentRouteParams['id'] ?? null;

        if (!$routeUserId) {
            return false;
        }

        return $userId == $routeUserId;
    }
}
