<?php

namespace app\view\Cart;

use app\model\OrderItem;
use app\model\Product;
use app\model\Unit;
use Illuminate\Database\Eloquent\Collection;

class CartView
{
    public function priceWithCurrencyUnit()
    {
        $price = $this->getRelation('price');
        if ($price) {
            $number            = number_format($price->price, 2, '.', ' ');
            $priceWithCurrency = "{$number} {$price->currency}";
            if ($this->activePromotions->count()) {
                return $this->priceWithCurrncyUnitPromotion($number, $price->currency, $number);
            }
            return "{$priceWithCurrency} / {$this->baseUnit->name}";
        }
        return 'цена - не определена';
    }

    public static function shippableUnitsSelector(Product $product): string
    {
        $options = '';
        if ($product->shippableUnits()->count()) {
            foreach ($product->shippableUnits as $unit) {
                $options .= self::getOptions($unit);
            }
        } else {
            $options .= self::getOptions($product->baseUnit);
        }
        return "<select class='units'>{$options}</select>";
    }

    protected static function getOptions(Unit $unit): string
    {
        $name       = $unit->name;
        $multiplier = $unit->pivot->multiplier ?? 1;
        $html       = "<option data-multiplier='{$multiplier}'>{$name}</option>";

        return $html;

    }
}