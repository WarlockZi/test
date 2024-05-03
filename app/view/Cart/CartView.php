<?php

namespace app\view\Cart;
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

}