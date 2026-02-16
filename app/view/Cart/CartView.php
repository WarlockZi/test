<?php

namespace app\view\Cart;

use app\model\Unit;


class CartView
{
    public function __construct()
    {
    }

    protected static function getOptions(Unit $unit, int $selecedId): string
    {
        $id         = $unit->id;
        $seleced    = $selecedId === $id ? "selected='selected'" : '';
        $name       = $unit->name;
        $multiplier = $unit->pivot->divider ?? 1;
        $html       = "<option data-divider='{$multiplier}' data-id='{$id}' {$seleced}>{$name}</option>";

        return $html;
    }

}