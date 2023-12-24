<?php namespace App\Components\AdminSidebar\Models;

use App\Components\AdminSidebar\Interfaces\IAdminSidebar;

class MenuItem
{
    public $caption;
    public $icon;
    public $url;
    public $childs = [];
    public $type;
    
    public function setType()
    {
        if (!empty($this->childs)) {
            $this->type = IAdminSidebar::ITEM_TYPE_TREE;
            return;
        }

        if (!empty($this->url)) {
            $this->type = IAdminSidebar::ITEM_TYPE_LINK;
            return;
        }

        $this->type = IAdminSidebar::ITEM_TYPE_CAPTION;
    }
}
