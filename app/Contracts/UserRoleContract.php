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

    public const EMPLOYEE_SLUG = 'employee';
    public const POINT_SLUG = 'point';
    public const MANAGER_SLUG = 'manager';
    public const SUPERVISOR_SLUG = 'supervisor';
    public const HR_SLUG = 'hr';
    public const ADMIN_SLUG = 'admin';

    public const ROLE_LIST = [
        self::EMPLOYEE_SLUG => [
            'slug' => self::EMPLOYEE_SLUG,
            'name' => 'Сотрудник'
        ],
        self::POINT_SLUG => [
            'slug' => self::POINT_SLUG,
            'name' => 'Точка продаж'
        ],
        self::MANAGER_SLUG => [
            'slug' => self::MANAGER_SLUG,
            'name' => 'Менеджер'
        ],
        self::SUPERVISOR_SLUG => [
            'slug' => self::SUPERVISOR_SLUG,
            'name' => 'Руководитель'
        ],
        self::HR_SLUG => [
            'slug' => self::HR_SLUG,
            'name' => 'Рекрутер'
        ],
        self::ADMIN_SLUG => [
            'slug' => self::ADMIN_SLUG,
            'name' => self::ADMIN_SLUG,
        ],
    ];
}
