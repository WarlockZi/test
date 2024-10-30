<?php


namespace app\view\share\card_panel;


use app\core\Auth;
use app\core\FS;
use app\core\Icon;
use app\model\Category;
use app\model\Product;

class CardPanel
{
	public static function card_panel(Product $product): string
	{
        $userIsAdmin = Auth::getUser()?->isAdmin();
        $fs = new FS(__DIR__);
        $edit = Icon::edit();
		return $fs->getContent('product_card_panel', compact('product', 'edit', 'userIsAdmin'));
	}
    public static function categoryCardPanel(Category $category, bool $forBreadcrumbs=false): string
    {
        $fs = new FS(__DIR__);
        $edit = Icon::edit();
        return $fs->getContent('category_card_panel', compact('category', 'edit','forBreadcrumbs'));
    }

}