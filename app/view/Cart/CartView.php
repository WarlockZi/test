<?php

namespace app\view\Cart;

use app\core\FS;
use app\model\Unit;

class CartView
{
    private FS $fs;
    public function __construct()
    {
        $this->fs = new FS(__DIR__);
    }

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

    protected static function getOptions(Unit $unit, int $selecedId): string
    {
        $id         = $unit->id;
        $seleced    = $selecedId === $id ? "selected='selected'" : '';
        $name       = $unit->name;
        $multiplier = $unit->pivot->multiplier ?? 1;
        $html       = "<option data-multiplier='{$multiplier}' data-id='{$id}' {$seleced}>{$name}</option>";

        return $html;
    }}