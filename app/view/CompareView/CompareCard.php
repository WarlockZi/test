<?php

namespace app\view\CompareView;

use app\core\FS;
use app\model\Compare;

class CompareCard
{
    private string $html;
    public function __construct(Compare $compare)
    {
        $product = $compare->product;
        $fs = new FS( dirname(__DIR__).'/Category');
        $txt = $product->txt;
        $this->html = $fs->getContent('product_card',compact('product','txt'));
    }

    public function toHtml()
    {
        return $this->html;
    }


}