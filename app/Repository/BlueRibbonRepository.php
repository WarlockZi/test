<?php

namespace app\Repository;

use app\core\Icon;

class BlueRibbonRepository
{
    public static function data()
    {
        $str      = '';
        $rootCats = CategoryRepository::showFrontCategories();

        $child_categories = [];
        foreach ($rootCats as $rootCat) {
            ob_start();
            self::buildMenu($rootCat['children_recursive']);
            $child_categories[$rootCat['name']] = ob_get_clean();
        }

        return [
            'front_categories' => CategoryRepository::frontCategories(),
//            'categories' => CategoryRepository::showFrontCategories(),
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
            echo $item['name'];
            if (!empty($item['children_recursive'])) {
                self::buildMenu($item['children_recursive']);
            }
            echo '</li>';
        }
        echo '</ul>';
        echo '<br>';
    }


}