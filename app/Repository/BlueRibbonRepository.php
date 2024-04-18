<?php

namespace app\Repository;

use app\core\Icon;
use app\model\Category;

class BlueRibbonRepository
{
    public static function data()
    {
        return [
            'categories' => Category::query()
                ->where('show_front', 1)
                ->with('childrenNotDeleted')
                ->get()->toArray(),
            'oItems' => OrderRepository::count(),
            'icon' => Icon::shoppingCart('feather'),
        ];
    }
}