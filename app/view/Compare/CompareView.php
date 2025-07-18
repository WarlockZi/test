<?php

namespace app\view\Compare;

use Illuminate\Database\Eloquent\Collection;

class CompareView
{
    public static function all(Collection $compares): string
    {
        $compareCards = '';
        foreach ($compares as $compare) {
            $compareCards .= (new CompareCard($compare))->toHtml();
        }
        $compareCards = !empty($compareCards)
            ? $compareCards
            : 'Вы не добавили товары для сравнения';
        $title        = '<h1 class="compare-h1">Страница сравнения товаров</h1>';

        return "$title<div class='product-wrap' data-compare>$compareCards</div>";
    }
}