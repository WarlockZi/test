<?php


namespace app\view\Promotion;


use app\core\FS;
use app\model\Promotion;
use app\model\Unit;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\CustomList;
use app\view\components\Builders\SelectBuilder\optionBuilders\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectNewBuilder;

class PromotionFormView
{

	static function edit($promotion)
	{
		$link = $promotion->product ? "adminsc/product/edit/{$promotion->product->id}" : 'adminsc/product/list';
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
				ItemFieldBuilder::build('unit', $promotion)
					->html(self::unitSelector($promotion->unit_id))
					->name('Единица')
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
					->html(FS::getFileContent(__DIR__ . '/Admin/active_till.php', compact('promotion')))
					->name('Действует до')
					->get()
			)
			->toList($link, 'К товару')
			->pageTitle('Акция')
			->get();

		return $promotion;
	}

	protected static function unitSelector($selected)
	{
		$s = SelectNewBuilder::build(
			ArrayOptionsBuilder::build(Unit::all())
				->selected($selected??0)
				->initialOption()
				->get()
		)
			->class('unit')
			->get();
		return $s;
	}

	public static function adminIndex($promotions)
	{

		$promotion = CustomList::build(Promotion::class)
			->items($promotions)
			->pageTitle('Акции')
			->column(
				ListColumnBuilder::build('product')
					->function(Promotion::class, 'productLink')
					->name('Товар')
					->get()
			)
			->column(
				ListColumnBuilder::build('count')
					->name('От количества')
					->get()
			)
			->column(
				ListColumnBuilder::build('active_till')
					->name('Действует до')
					->get()
			)
			->column(
				ListColumnBuilder::build('new_price')
					->name('Цена по акции')
					->get()
			)
			->del()
//			->softDel()
			->edit()
			->get();

		return $promotion;
	}

}