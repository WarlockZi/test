<?php

namespace app\Repository;

use app\core\Icon;
use app\model\Category;

class BlueRibbonRepository
{
    public static function data()
    {
        return [
            'categories' => CategoryRepository::showFrontCategories(),
            'oItems' => CartRepository::count(),
            'icon' => Icon::shoppingCart('feather'),
        ];
    }
}