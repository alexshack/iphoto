<?php

namespace App\Contracts\Money;

interface RoleExpensesTypeContract
{
    public const TABLE = 'expenses_type_role';
    public const FIELD_ID = 'id';
    public const FIELD_EXPENSES_TYPE_ID = 'expenses_type_id';
    public const FIELD_ROLE_ID = 'role_id';
}
