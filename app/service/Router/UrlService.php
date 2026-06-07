<?php

namespace app\service\Router;

use app\model\Category;

class UrlService
{

    public static function getCategoryOwnPropPath(Category $category): string
    {
        if (!$category->parent) return $category->slug;

        $path          = [];
        $localCategory = $category;
        while ($localCategory->parent) {
            $path[]   = $localCategory->parent->slug;
            $localCategory = $localCategory->parent;
        }
        return implode('/', array_reverse($path)) . '/' . $category->slug;
    }
}