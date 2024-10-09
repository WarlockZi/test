<?php

namespace app\Repository;

use app\core\Icon;
use Illuminate\Database\Eloquent\Collection;


class BlueRibbonRepository
{
    public static function data()
    {
        $rootCats = CategoryRepository::frontCategories();

        $child_categories = [];
        foreach ($rootCats as $rootCat) {
            ob_start();
            self::buildMenu($rootCat->childrenRecursive);
            $child_categories[$rootCat['name']] = ob_get_clean();
        }

        return [
            'front_categories' => CategoryRepository::frontCategories(),
            'child_categories' => $child_categories,
            'oItems' => CartRepository::count(),
            'icon' => Icon::shoppingCart('feather'),
        ];
    }

    private static function buildMenu(Collection $categories)
    {
        echo '<ul class="show-front_submenu mtree">';
        foreach ($categories as $item) {
            echo '<li>';
            echo "<a href='{$item->href}'>{$item->name}</a>";
            if (!empty($item->childrenRecursive)) {
                self::buildMenu($item->childrenRecursive);
            }
            echo '</li>';
        }
        echo '</ul>';
        echo '<br>';
    }


}