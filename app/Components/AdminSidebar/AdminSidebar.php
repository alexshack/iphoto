<?php namespace App\Components\AdminSidebar;

use App\Components\AccessManager\Interfaces\IAccessManager;
use App\Components\AdminSidebar\Helpers\StructureHelper;
use App\Components\AdminSidebar\Interfaces\IAdminSidebar;
use App\Components\AdminSidebar\Models\MenuItem;
use App\Contracts\UserWorkDataContract;
use Illuminate\Support\Facades\Auth;

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
        // TODO: del
        // echo '<pre>' . var_export($structure, true) . '</pre>'; exit();
        $structureModel = [];

        foreach ($structure as $key => $item) {
            if (str_contains(strtolower($key), 'title')) {
                continue;
            }

            $route = $item['routeName'] ?? null;
            $routeParams = $item['routeParams'] ?? null;
            $routeAccess = $route
                ? $this->accessManager->checkRouteAccess($route, null, $routeParams)
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
            $routeParams = $structureItem['routeParams'] ?? null;
            $routeParams = $this->fillRouteParams($routeParams, $structureItem['routeFill'] ?? null);
            $menuItem->url = route($structureItem['routeName'], $routeParams);
        }

        if (isset($structureItem['childs']) && empty($structureItem['childs'])) {
            return null;
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

    protected function fillRouteParams($currentParams, $fillFields = null)
    {
        if (!$fillFields || empty($fillFields)) {
            return $currentParams;
        }

        if (!is_array($currentParams)) {
            $currentParams = [];
        }

        foreach ($fillFields as $fieldName) {
            switch ($fieldName) {
                case UserWorkDataContract::FIELD_CITY_ID:
                    $currentParams[UserWorkDataContract::FIELD_CITY_ID] = $this->getCurrentUserCityId();
                    break;
            }
        }

        return array_filter($currentParams);
    }

    protected function getCurrentUserCityId()
    {
        $user = Auth::user();
        if (!$user) {
            return null;
        }


        return $user->getWorkData()->city_id;
    }
}
