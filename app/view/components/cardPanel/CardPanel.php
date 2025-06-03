<?php


namespace app\view\components\cardPanel;
use app\model\Category;
use app\model\Product;
use app\service\FS;
use app\view\components\Icon\Icon;

class CardPanel
{
    public static function card_panel(Product $product): array
    {
        return [
            'product' => $product,
            'edit'=>Icon::edit(),
            'forBreadcrumbs'=>false,
        ];
//        $edit = Icon::edit();
//        return $fs->getContent('product_card_panel', compact('product', 'edit'));
    }

    public static function categoryCardPanel(array $category, bool $forBreadcrumbs = false): array
    {
        return [
            'category' => $category,
            'edit'=>Icon::edit(),
            'forBreadcrumbs'=>$forBreadcrumbs,
        ];

//        $edit = ;
//        return $category;
//        return $fs->getContent('category_card_panel', compact('category', 'edit', 'forBreadcrumbs'));
    }

}