<?php

namespace app\Repository;

use app\Services\CatalogMobileMenu\CatalogMobileMenuService;
use app\view\Icon;


class BlueRibbonRepository
{
    public static function data(): array
    {
        $mC = APP->get(CatalogMobileMenuService::class)->get();
        return [
            'front_categories' => APP->get('rootCategories'),
            'child_categories' => self::getChildCategoriesNew(),
            'oItemsCount' => OrderRepository::count(),
            'icon' => Icon::shoppingCart('feather'),
            'mobile_categories' => $mC->get(),
        ];
    }

    public static function getChildCategories(): array
    {
        $child_categories = [];
        foreach (APP->get('rootCategories') as $rootCat) {
            ob_start();
            self::buildMenu($rootCat['children_recursive']);
            $child_categories[$rootCat['name']] = ob_get_clean();
        }
        return $child_categories;
    }

    public static function getChildCategoriesNew($child_categories = []): array
    {
        foreach (APP->get('rootCategories') as $rootCat) {
            array_push($child_categories, $rootCat->childrenRecursive);
        }
        return $child_categories->toArray();

    }

    private static function buildMenu(array $categories, int $i = 1): void
    {
        echo "<ul class='h-cat_submenu level-{$i}'>";
        foreach ($categories as $item) {
            echo "<li class='h-cat_item'>";
            self::renderLink($item, $i);
            echo '</li>';
        }
        echo '</ul>';
    }

    private static function renderLink(array $category, int $i): void
    {
        if (count($category['children_recursive'])) {
            echo "<div class = 'wrap'>" .
                "<a href='{$category['href']}'>{$category['name']}</a>" .
                "<span class='arrow'>></span>" .
                "</div>";
            self::buildMenu($category['children_recursive'], ++$i);
        } else {
            echo "<a href='{$category['href']}'>{$category['name']}</a>";
        }
    }


}