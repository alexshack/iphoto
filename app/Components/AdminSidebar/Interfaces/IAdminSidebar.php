<?php namespace App\Components\AdminSidebar\Interfaces;

interface IAdminSidebar
{
    const ITEM_TYPE_CAPTION = 1;
    const ITEM_TYPE_LINK = 2;
    const ITEM_TYPE_TREE = 3;

    public function getSidebar($userRoleSlug = null);
}
