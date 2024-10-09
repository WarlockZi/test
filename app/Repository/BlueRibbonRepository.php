<?php

namespace app\Repository;

use app\core\Icon;

class BlueRibbonRepository
{
    public static function data()
    {
        $str      = '';
        $rootCatProps = CategoryRepository::showFrontCategories();

        $child_categories = [];
        foreach ($rootCatProps as $rootCatProp) {
            ob_start();
            self::buildMenu($rootCatProp['category']['children_recursive']);
            $child_categories[$rootCatProp['category']['name']] = ob_get_clean();
        }

        return [
            'front_categories' => CategoryRepository::frontCategories(),
            'child_categories' => $child_categories,
            'oItems' => CartRepository::count(),
            'icon' => Icon::shoppingCart('feather'),
        ];
    }

    private static function buildMenu($array)
    {
        echo '<ul class="show-front_submenu mtree">';
        foreach ($array as $item) {
            echo '<li>';
            echo "<a href='{$item['href']}'>{$item['name']}</a>";
            if (!empty($item['children_recursive'])) {
                self::buildMenu($item['children_recursive']);
            }
            echo '</li>';
        }
        echo '</ul>';
        echo '<br>';
    }


}