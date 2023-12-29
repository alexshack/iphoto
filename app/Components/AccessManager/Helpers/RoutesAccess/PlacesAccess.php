<?php namespace App\Components\AccessManager\Helpers\RoutesAccess;

use App\Components\AccessManager\Interfaces\IAccessManager;
use App\Contracts\UserWorkDataContract;
use App\Models\Structure\Place;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class PlacesAccess
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
                case UserWorkDataContract::FIELD_CITY_ID:
                    $access = self::checkoutPlacesCityId($routeParams);
                    break;
            }

            if (!$access) {
                return false;
            } 
        }

        return $access;
    }

    /* Helpers */
    protected static function checkoutPlacesCityId($routeParams = null)
    {
        $userCityId = Auth::user()->getWorkData()->city_id;
        if (!$userCityId) {
            return false;
        }

        $currentRouteParams = Route::current()->parameters();
        $placeId = $routeParams['id'] ?? $currentRouteParams['id'] ?? null;

        if (!$placeId) {
            return false;
        }

        $place = Place::where(['id' => $placeId])->first();
        if (!$place) {
            return false;
        }

        return $userCityId === $place->city_id;
    }
}
