<?php

namespace app\service\Router;

use app\model\Category;

class UrlService
{
//    public static function generateUrls(): void
//    {
//        Category::with('parent')->get()->each(function (Category $category) {
//            self::setCategoryOwnPropPath($category);
//        });
//    }

    public static function getCategoryOwnPropPath(Category $category): string
    {
        $path = [];
        if (!$category->parent) {
            return $category->slug;
//            $res = $category->ownProperties->update(['path' => $category->slug]);
        } else {
            $localCategory = $category;
            while ($category->parent) {
                $path[]   = $category->parent->slug;
                $category = $category->parent;
            }
            $str = implode('/', array_reverse($path)) . '/' . $localCategory->slug;
            return $str;
//            $localCategory->ownProperties->update(['path' => $str]);
        }
    }
}