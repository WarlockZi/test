<?php


namespace app\view\components\cardPanel;
use app\model\Product;
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
    }

    public static function categoryCardPanel(array $category, bool $forBreadcrumbs = false): array
    {
        return [
            'category' => $category,
            'edit'=>Icon::edit(),
            'forBreadcrumbs'=>$forBreadcrumbs,
        ];
    }

}