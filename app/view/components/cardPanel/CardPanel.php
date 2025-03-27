<?php


namespace app\view\components\cardPanel;
use app\model\Category;
use app\model\Product;
use app\Services\FS;
use app\view\Icon;

class CardPanel
{
    public static function card_panel(Product $product): string
    {
        $fs   = new FS(__DIR__);
        $edit = Icon::edit();
        return $fs->getContent('product_card_panel', compact('product', 'edit'));
    }

    public static function categoryCardPanel(Category $category, bool $forBreadcrumbs = false): string
    {
        $fs   = new FS(__DIR__);
        $edit = Icon::edit();
        return $fs->getContent('category_card_panel', compact('category', 'edit', 'forBreadcrumbs'));
    }

}