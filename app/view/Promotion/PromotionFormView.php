<?php


namespace app\view\Promotion;


use app\core\FS;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;

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
					->html(self::activeTill($promotion))
					->name('Действует до')
					->get()
			)
			->toList("adminsc/product/edit/{$promotion->product['id']}", 'К товару')
			->pageTitle('Акция')
			->get();

		return $promotion;
	}

	protected static function activeTill($promotion){
		return FS::getFileContent(__DIR__.'/Admin/active_till.php',compact('promotion'));

	}

}