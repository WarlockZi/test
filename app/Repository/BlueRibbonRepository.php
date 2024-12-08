<?php

namespace app\Repository;

use app\core\Icon;
use app\model\Category;
use app\Services\CatalogMobileMenu\CatalogMobileMenuService;
use Illuminate\Database\Eloquent\Collection;


class BlueRibbonRepository
{
    public static function data($rootCategories): array
    {
        $child_categories = [];
        foreach ($rootCategories as $rootCat) {
            ob_start();
            self::buildMenu($rootCat->childrenRecursive->toArray());
            $child_categories[$rootCat->name] = ob_get_clean();
        }

        return [
            'front_categories' => CategoryRepository::frontCategories(),
            'child_categories' => $child_categories,
            'oItems' => CartRepository::count(),
            'icon' => Icon::shoppingCart('feather'),
            'mobile_categories'=>(new CatalogMobileMenuService())->get(),
        ];
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