<?php

namespace app\view\Compare;

use app\model\Compare;
use app\service\FS;

class CompareCard
{
    private string $html;

    public function __construct(Compare $compare)
    {
        $product    = $compare->product;
        $fs         = new FS();
        $txt        = $product->txt;
        $this->html = $fs->getContent('product_card', compact('product', 'txt'));
    }

    public function toHtml()
    {
        return $this->html;
    }


}