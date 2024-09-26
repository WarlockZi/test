<?php


namespace app\view\share\card_panel;


use app\core\Auth;
use app\core\FS;
use app\core\Icon;
use app\model\Product;

class CardPanel
{
	public static function card_panel(Product $product): string
	{
        $userIsAdmin = Auth::userIsAdmin();
        $fs = new FS(__DIR__);
        $edit = Icon::edit();
		return $fs->getContent('card_panel', compact('product', 'edit', 'userIsAdmin'));
	}

}