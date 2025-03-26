<?php

namespace app\view\Compare;

use app\model\Compare;
use app\Services\FS;

class CompareCard
{
    private string $html;

    public function __construct(Compare $compare)
    {
        $product    = $compare->product;
        $fs         = new FS(dirname(__DIR__) . '/Category');
        $txt        = $product->txt;
        $this->html = $fs->getContent('product_card', compact('product', 'txt'));
    }

    public function toHtml()
    {
        return $this->html;
    }


}