<?php


namespace app\view\Promotion;


use app\core\FS;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;

class PromotionFormView
{

	static function edit($promotion)
	{
		$promotion = ItemBuilder::build($promotion, 'promotion')
			->field(
				ItemFieldBuilder::build('id', $promotion)
					->get()
			)
			->field(
				ItemFieldBuilder::build('count', $promotion)
					->name('количество')
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('new_price', $promotion)
					->contenteditable()
					->name('новая цена')
					->get()
			)

			->field(
				ItemFieldBuilder::build('active_till', $promotion)
					->html(FS::getFileContent(__DIR__.'/Admin/active_till.php',compact('promotion')))
					->name('Действует до')
					->get()
			)
			->toList("adminsc/product/edit/{$promotion->product['id']}", 'К товару')
			->pageTitle('Акция')
			->get();

		return $promotion;
	}


	public static function index($promotions){

		$promotion = MyList::build($promotions)
			->pageTitle('Акции')
			->column(
				ListColumnBuilder::build('product')
					->name('Товар')
					->get()
			)
			->del()
			->edit()
			->get();

		return $promotion;
	}

}