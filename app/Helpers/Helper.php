<?php

namespace App\Helpers;

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
}
