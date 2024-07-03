<?php


namespace app\view\share\card_panel;


use app\core\FS;
use app\core\Icon;
use app\model\Product;

class CardPanel
{
	public static function card_panel(Product $product): string
	{
        $fs = new FS(__DIR__);
        $edit = Icon::edit();
		return $fs->getContent('card_panel', compact('product', 'edit'));
	}

}