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

    public const MANAGER_SLUG = 'manager';

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
            'name' => 'Администратор'
        ],
    ];
}
