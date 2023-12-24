<?php namespace App\Components\AdminSidebar;

use App\Components\AccessManager\Interfaces\IAccessManager;
use App\Components\AdminSidebar\Helpers\StructureHelper;
use App\Components\AdminSidebar\Interfaces\IAdminSidebar;
use App\Components\AdminSidebar\Models\MenuItem;

class AdminSidebar implements IAdminSidebar
{
    protected $accessManager;

    public function __construct(
        IAccessManager $accessManager
    ) {
        $this->accessManager = $accessManager;
    }

    public function getSidebar($userRoleSlug = null)
    {
        $structure = StructureHelper::barStructure();
        $model = $this->getStructureModel($structure);

        return $model;
    }

    protected function getStructureModel($structure)
    {
        $structureModel = [];

        foreach ($structure as $key => $item) {
            if (str_contains(strtolower($key), 'title')) {
                continue;
            }

            $route = $item['routeName'] ?? null;
            $routeAccess = $route
                ? $this->accessManager->checkRouteAccess($route)
                : true;

            if (!$routeAccess) {
                continue;
            }

            $itemModel = $this->newMenuItem($item);
            if (!$itemModel) {
                continue;
            }

            $this->checkoutItemTitle($item, $structureModel, $structure);

            $itemModel->setType();
            $structureModel[] = $itemModel;
        }

        return $structureModel;
    }

    protected function newMenuItem($structureItem)
    {
        $menuItem = new MenuItem;

        $menuItem->caption = $structureItem['caption'] ?? null;
        $menuItem->icon = $structureItem['icon'] ?? null;

        $route = $structureItem['routeName'] ?? null;
        if ($route) {
            $menuItem->url = route($structureItem['routeName'], $structureItem['routeParams'] ?? null);
        }

        if (isset($structureItem['childs']) && !empty($structureItem['childs'])) {
            $menuItem->childs = $this->getStructureModel($structureItem['childs']);
            if (empty($menuItem->childs)) {
                return null;
            }
        }

        return $menuItem;
    }

    protected function checkoutItemTitle($structureItem, &$menuModel, &$rawStructure)
    {
        $titleName = $structureItem['title'] ?? null;
        if (!$titleName) {
            return;
        }

        if (key_exists($titleName, $menuModel)) {
            return;
        }

        $titleItem = $rawStructure[$titleName] ?? null;
        if (!$titleItem) {
            return;
        }

        $menuItem = new MenuItem;
        $menuItem->caption = $titleItem['caption'] ?? null;
        $menuItem->setType();

        $menuModel[$titleName] = $menuItem;
    }
}
