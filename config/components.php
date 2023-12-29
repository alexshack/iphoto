<?php

use App\Components\AccessManager\Interfaces\IAccessManager;
use App\Contracts\UserRoleContract;
use App\Contracts\UserWorkDataContract;

return [
    'accessManager' => [
        'routesAccess' => [
            UserRoleContract::ADMIN_SLUG => IAccessManager::FULL_ACCESS,
            UserRoleContract::EMPLOYEE_SLUG => array_merge(
                IAccessManager::COMMON_ROUTES, [
                    'money.days*',
                ]
            ),
            UserRoleContract::POINT_SLUG => array_merge(
                IAccessManager::COMMON_ROUTES, []
            ),
            UserRoleContract::MANAGER_SLUG => array_merge(
                IAccessManager::COMMON_ROUTES, [
                    ['admin.structure.places.edit', IAccessManager::COMPARE_WITH => UserWorkDataContract::FIELD_CITY_ID],
                    'admin.structure.places.index',
                    'admin.structure.employees.*',
                    'admin.money.incomes.*',
                    'admin.money.expenses.*',
                    'admin.money.moves.*',
                    'admin.salary.calc.*',
                    'admin.salary.pay.*',
                    'admin.salary.pays_list',
                ]
            ),
            UserRoleContract::SUPERVISOR_SLUG => array_merge(
                IAccessManager::COMMON_ROUTES, []
            ),
            UserRoleContract::HR_SLUG => array_merge(
                IAccessManager::COMMON_ROUTES, []
            ),
        ],
    ],
];
