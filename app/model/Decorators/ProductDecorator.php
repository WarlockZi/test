<?php

namespace app\model\Decorators;

use app\model\Product;

class ProductDecorator
{
    public
    function pricesUnitsArray(Product $product): array
    {
        $array    = [];
        $price    = $this->price($product);
        $baseUnit = $this->baseUnit($product);
        $dopUnits = $this->dopUnits($product);
        if ($baseUnit) {
            $array['baseUnit']['price'] = number_format($price, 2, '.', ' ');
            $array['baseUnit']['unit']  = $baseUnit->name;
        }
        if ($dopUnits->count()) {
            foreach ($dopUnits as $unit) {
                $multiplier                              = $unit->pivot->multiplier;
                $array['dopUnits'][$multiplier]['price'] = number_format($price * $multiplier, 2, '.', ' ');
                $array['dopUnits'][$multiplier]['unit']  = $unit->name;
            }
        }
        return $array;
    }


}