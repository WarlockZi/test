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
        $baseUnit = $product->baseUnit->first() ?? 'ед отсутств';
        $price          = (int)$product->getRelation('price')->price;
        $formattedPrice = $price
            ? number_format($price, 2, '.', ' ')
            : 'Цену уточняйте у менеджера';

        return "{$formattedPrice} ₽ / {$baseUnit->name}";
    }

    public function dopUnitsPrices(Product $product): string
    {
        $dopUnits = $product->dopUnits;
        if (!$dopUnits->count()) return '';
        $price = $product->price;
        $str = '';
        foreach ($dopUnits as $unit) {
            $multiplier     = $unit->pivot->multiplier;
            $formattedPrice = $price && $multiplier
                ? number_format($price, 2, '.', ' ')
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