<?php

namespace app\view\Cart;

use app\model\Unit;
use app\Services\FS;

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
        $multiplier = $unit->pivot->multiplier ?? 1;
        $html       = "<option data-multiplier='{$multiplier}' data-id='{$id}' {$seleced}>{$name}</option>";

        return $html;
    }

}