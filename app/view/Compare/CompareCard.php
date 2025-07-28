<?php

namespace app\view\Compare;

use app\model\Compare;
use JetBrains\PhpStorm\NoReturn;

class CompareCard
{
    private string $html;

    #[NoReturn] public function __construct(Compare $compare)
    {
        $product    = $compare->product;
        $txt        = $product->txt;
        view('pages.compares', compact('product', 'txt'));
    }

}