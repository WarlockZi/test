<?php

namespace app\Repository;

use app\core\Cache;
use app\core\Icon;
use app\Services\CatalogMobileMenu\CatalogMobileMenuService;


class BlueRibbonRepository
{
    public static function data($rootCategories): array
    {
        return [
            'front_categories' => CategoryRepository::rootCategories(),
            'child_categories' => self::getRootCategories($rootCategories),
            'oItemsCount' => OrderRepository::count(),
            'icon' => Icon::shoppingCart('feather'),
            'mobile_categories' => (new CatalogMobileMenuService())->get(),
        ];
    }

    private static function getRootCategories($rootCategories): array
    {
        return Cache::get('blueRibbonCategories',
            function () use ($rootCategories) {
                $child_categories = [];
                foreach ($rootCategories as $rootCat) {
                    ob_start();
                    self::buildMenu($rootCat->childrenRecursive->toArray());
                    $child_categories[$rootCat->name] = ob_get_clean();
                }
                return $child_categories;
            }, Cache::$timeLife1_000);
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

    private static function renderLink(array $item, int $i): void
    {
        if (count($item['children_recursive'])) {
            echo "<div class = 'wrap'>" .
                "<a href='{$item['href']}'>{$item['name']}</a>" .
                "<span class='arrow'>></span>" .
                "</div>";
            self::buildMenu($item['children_recursive'], ++$i);
        } else {
            echo "<a href='{$item['href']}'>{$item['name']}</a>";
        }
    }


}