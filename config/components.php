<?php

use App\Components\AccessManager\Interfaces\IAccessManager;
use App\Contracts\UserRoleContract;

return [
    'accessManager' => [
        'routesAccess' => [
            UserRoleContract::ADMIN_SLUG => IAccessManager::FULL_ACCESS,
            UserRoleContract::POINT_SLUG => array_merge(
                IAccessManager::COMMON_ROUTES, [
                    'money.days*',
                ]
            ),
            UserRoleContract::MANAGER_SLUG => array_merge(
                IAccessManager::COMMON_ROUTES, [
                    'admin.structure.places.*',
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
                IAccessManager::COMMON_ROUTES, [
                ]
            ),
            UserRoleContract::HR_SLUG => array_merge(
                IAccessManager::COMMON_ROUTES, [
                ]
            ),
        ],
    ],
];
