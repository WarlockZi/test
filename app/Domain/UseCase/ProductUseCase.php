<?php

namespace app\Domain\UseCase;

use app\model\Decorators\ProductDecorator;
use app\model\Product;

class ProductUseCase
{
    protected ProductDecorator $productDecorator;

    public function __construct()
    {
        $this->productDecorator = new ProductDecorator();
    }

    public function baseUnitPrice(Product $product): string
    {
        $baseUnit       = $product->baseUnit->first() ?? 'ед отсутств';
        $price          = (float)$product->getRelation('price')->price;
        $formattedPrice = $price
            ? number_format($price, 2, '.', ' ')
            : 'Цену уточняйте у менеджера';

        return "{$formattedPrice} ₽ / {$baseUnit->name}";
    }

    public function dopUnitsPrices(Product $product): string
    {
        $shippableUnits = $product->shippableUnits;
        if (!$product->shippableUnits->count()) return '';
        $price = $product->price;
        $str   = '';
        foreach ($shippableUnits as $unit) {
            $multiplier     = $unit->pivot->multiplier ?? 1;
            $formattedPrice = $price && $multiplier
                ? number_format((float)$price * $multiplier, 2, '.', ' ')
                : 'Цену уточняйте у менеджера';
            $str            .= "<div class='price-unit-row'>
                <div class='price-for-unit'>
                     {$formattedPrice}
                </div>
                ₽ /
                <div class='unit'>{$unit->name}</div>

            </div>";
        }
        return $str;

    }
}