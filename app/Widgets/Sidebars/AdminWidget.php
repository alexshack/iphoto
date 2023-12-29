<?php namespace App\Widgets\Sidebars;

use App\Components\AdminSidebar\Interfaces\IAdminSidebar;
use App\Widgets\Contract\ContractWidget;

class AdminWidget implements ContractWidget
{
    protected $sidebar;

    public function __construct(
        IAdminSidebar $sidebar
    ) {
        $this->sidebar = $sidebar;
    }

    public function execute()
    {
        $bar = $this->sidebar->getSidebar();
        return view('widgets.sidebars.admin', ['bar' => $bar]);
    }
}
