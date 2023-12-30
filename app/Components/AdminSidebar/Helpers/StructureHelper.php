<?php namespace App\Components\AdminSidebar\Helpers;

use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Contracts\UserWorkDataContract;
use App\Models\City;

class StructureHelper
{
    public static function barStructure()
    {
        $cities = City::all();
        $menuCities = [];
        foreach ($cities as $city) {
            $cityMenu = [
                'caption' => $city->{ CityContract::FIELD_NAME }
            ];

            $places = $city->places;
            if (!empty($places)) {
                $cityMenu['childs'] = [];
                foreach ($places as $place) {
                    $cityMenu['childs'][] = [
                        'caption' => $place->{ PlaceContract::FIELD_NAME },
                        'routeName' => 'admin.structure.places.edit',
                        'routeParams' => ['id' => $place->{ PlaceContract::FIELD_ID }],
                    ];
                }
            }

            $menuCities[] = $cityMenu;
        }

        $structure = [
            [
                'caption' => 'Главная',
                'icon' => 'feather-home',
                'routeName' => 'admin.home',
            ],

            'companyTitle' => ['caption' => 'Компания'],
            empty($menuCities)
                ? null
                : [
                    'caption' => 'Структура',
                    'icon' => 'feather-camera',
                    'title' => 'companyTitle',
                    'childs' => $menuCities,
                ],
            [
                'caption' => 'Справочники',
                'icon' => 'feather-server',
                'title' => 'companyTitle',
                'childs' => [
                    [
                        'caption' => 'Города',
                        'routeName' => 'admin.structure.cities.index',
                    ],
                    [
                        'caption' => 'Точки',
                        'routeName' => 'admin.structure.places.index',
                        'routeFill' => [UserWorkDataContract::FIELD_CITY_ID],
                    ],
                    [
                        'caption' => 'Менеджеры',
                        'routeName' => 'admin.structure.managers.index',
                    ],
                    [
                        'caption' => 'Сотрудники',
                        'routeName' => 'admin.structure.employees.index',
                        'routeFill' => [UserWorkDataContract::FIELD_CITY_ID],
                    ],
                    [
                        'caption' => 'Рекрутеры',
                        'routeName' => 'admin.structure.hrs.index',
                    ],
                ],
            ],

            'finTitle' => ['caption' => 'Финансовый учет'],
            [
                'caption' => 'Документы',
                'icon' => 'feather-layers',
                'title' => 'finTitle',
                'childs' => [
                    [
                        'caption' => 'Смены',
                        'routeName' => 'money.days',
                        'routeFill' => [UserWorkDataContract::FIELD_CITY_ID],
                    ],
                    [
                        'caption' => 'Поступления ДС',
                        'routeName' => 'admin.money.incomes.index',
                        'routeFill' => [UserWorkDataContract::FIELD_CITY_ID],
                    ],
                    [
                        'caption' => 'Расходы ДС',
                        'routeName' => 'admin.money.expenses.index',
                        'routeFill' => [UserWorkDataContract::FIELD_CITY_ID],
                    ],
                    [
                        'caption' => 'Перемещение ДС',
                        'routeName' => 'admin.money.moves.index',
                        'routeFill' => [UserWorkDataContract::FIELD_CITY_ID],
                    ],
                ],
            ],
            [
                'caption' => 'Справочники',
                'icon' => 'feather-server',
                'title' => 'finTitle',
                'childs' => [
                    [
                        'caption' => 'Виды продаж',
                        'routeName' => 'admin.money.sales_types.index',
                    ],
                    [
                        'caption' => 'Виды поступлений',
                        'routeName' => 'admin.money.incomes_types.index',
                    ],
                    [
                        'caption' => 'Виды расходов',
                        'routeName' => 'admin.money.expenses_types.index',
                    ],
                ],
            ],

            'salaryTitle' => ['caption' => 'Учет зарплаты'],
            [
                'caption' => 'Документы',
                'icon' => 'feather-layers',
                'title' => 'salaryTitle',
                'childs' => [
                    [
                        'caption' => 'Начисления',
                        'routeName' => 'admin.salary.calc.index',
                        'routeFill' => [UserWorkDataContract::FIELD_CITY_ID],
                    ],
                    [
                        'caption' => 'Выплаты',
                        'routeName' => 'admin.salary.pay.index',
                        'routeFill' => [UserWorkDataContract::FIELD_CITY_ID],
                    ],
                    [
                        'caption' => 'Списки на зп и оклад',
                        'routeName' => 'admin.salary.pays_list',
                        'routeFill' => [UserWorkDataContract::FIELD_CITY_ID],
                    ],
                ],
            ],
            [
                'caption' => 'Справочники',
                'icon' => 'feather-server',
                'title' => 'salaryTitle',
                'childs' => [
                    [
                        'caption' => 'Статусы сотрудников',
                        'routeName' => 'admin.salary.employee_statuses.index',
                    ],
                    [
                        'caption' => 'Должности сотрудников',
                        'routeName' => 'admin.salary.employee_positions.index',
                    ],
                    [
                        'caption' => 'Виды начислений',
                        'routeName' => 'admin.salary.calc_type.index',
                    ],
                ],
            ],

            'goodsTitle' => ['caption' => 'Товарный учет'],
            [
                'caption' => 'Товары',
                'icon' => 'feather-box',
                'title' => 'goodsTitle',
                'routeName' => 'admin.goods.index',
            ],
            [
                'caption' => 'Настройки',
                'icon' => 'feather-settings',
                'routeName' => 'settings.index',
            ],
        ];

        return array_filter($structure);
    }
}
