<?php

namespace App\Helpers;

use App\Contracts\UserRoleContract;
use App\Models\City;
use App\Models\Structure\Place;
use App\Models\User;
use Carbon\Carbon;

class Helper
{
    protected static $monthsList = [
        1 => 'Январь',
        2 => 'Февраль',
        3 => 'Март',
        4 => 'Апрель',
        5 => 'Май',
        6 => 'Июнь',
        7 => 'Июль',
        8 => 'Август',
        9 => 'Сентябрь',
        10 => 'Октябрь',
        11 => 'Ноябрь',
        12 => 'Декабрь',
    ];

    public static function dateFilterFormat($dateString)
    {
        $months_id = [
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            12,
        ];
        $months_names = [
            'Январь',
            'Февраль',
            'Март',
            'Апрель',
            'Май',
            'Июнь',
            'Июль',
            'Август',
            'Сентябрь',
            'Октябрь',
            'Ноябрь',
            'Декабрь',
        ];

        $dateArray = explode(' ', $dateString);
        return ['month' => str_replace($months_names, $months_id, $dateArray[0]), 'year' => $dateArray[1]];
    }

    public static function getMonthName($id)
    {
        return self::$monthsList[$id] ?? null;
    }

    public static function getEntityEditRoute($entity) {
        $route = '';
        switch (get_class($entity)) {
        case Place::class:
            $route = route('admin.structure.places.edit', ['id' => $entity->id]);
            break;
        case User::class:
            if ($entity->role->slug === UserRoleContract::MANAGER_SLUG) {
                $route = route('admin.structure.managers.edit', ['id' => $entity->id]);
            }
            break;
        case City::class:
            $route = route('admin.structure.cities.edit', ['id' => $entity->id]);
            break;
        default:
            $route = get_class($entity);
            break;
        }
        return $route;
    }

    public static function escapeJsonString($value) { # list from www.json.org: (\b backspace, \f formfeed)
        $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
        $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
        $result = str_replace($escapers, $replacements, $value);
        return $result;
    }

    public static function prepareJsonString($data) {
        return self::escapeJsonString(json_encode($data));
    }

    public static function timeToTimestamp($timeC, $placeWorkStartTimeC, $midnight = null, $endOfDay = null) {
        if (!$midnight) {
            $midnight = Carbon::parse('00:00:00');
        }

        if (!$endOfDay) {
            $endOfDay = Carbon::parse('23:59:59');
        }

        $timeStamp = 0;
        if ($timeC->greaterThanOrEqualTo($placeWorkStartTimeC)) {
            $timeStamp = $placeWorkStartTimeC->diffInMinutes($timeC);
        } else if ($timeC->greaterThanOrEqualTo($midnight) && $timeC->lessThan($placeWorkStartTimeC)) {
            $timeStamp = $placeWorkStartTimeC->diffInMinutes($endOfDay);
            $timeStamp += $midnight->diffInMinutes($timeC) + 1;
        }
        return $timeStamp;
    }
}
