<?php

namespace App\Contracts;

interface UserRoleContract
{
    public const TABLE = 'roles';
    public const FIELD_ID = 'id';
    public const FIELD_SLUG = 'slug';
    public const FIELD_NAME = 'name';

    public const FILLABLE_FIELDS = [
        self::FIELD_SLUG,
        self::FIELD_NAME,
    ];

    public const ADMIN_SLUG = 'admin';

    public const EMPLOYEE_SLUG = 'employee';

    public const MANAGER_SLUG = 'manager';

    public const POINT_SLUG = 'point';

    public const SUPERVISOR_SLUG = 'supervisor';

    public const HR_SLUG = 'hr';

    public const ROLE_LIST = [
        [
            'slug' => 'employee',
            'name' => 'Сотрудник'
        ],
        [
            'slug' => 'point',
            'name' => 'Точка продаж'
        ],
        [
            'slug' => self::MANAGER_SLUG,
            'name' => 'Менеджер'
        ],
        [
            'slug' => 'supervisor',
            'name' => 'Руководитель'
        ],
        [
            'slug' => 'hr',
            'name' => 'Рекрутер'
        ],
        [
            'slug' => 'admin',
            'name' => self::ADMIN_SLUG,
        ],
    ];
}
