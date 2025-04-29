<?php

namespace app\service\Router;

use app\model\Category;

class UrlService
{
    public static function generateUrls(): void
    {
        Category::with('parent')->get()->each(function (Category $category) {
            self::setCateoryOwnPropPath($category);
        });
    }

    public static function setCateoryOwnPropPath(Category $category): void
    {
        $path = [];
        if (!$category->parent) {
            $category->ownProperties->path = $category->slug;
            $category->ownProperties->save();
        } else {
            $localCategory = $category;
            while ($category->parent) {
                $path[]   = $category->parent->slug;
                $category = $category->parent;
            }
            $str                                = implode('/', array_reverse($path)) . '/' . $localCategory->slug;
            $localCategory->ownProperties->path = $str;
            $localCategory->ownProperties->save();
        }
    }
}