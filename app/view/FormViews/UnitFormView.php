<?php


namespace app\view\FormViews;


use app\model\Unit;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use app\view\components\Builders\Morph\MorphBuilder;

class UnitFormView
{

	public static function edit($unit): string
	{
		$list = self::morphs($unit->units);

		return
			MorphBuilder::build($unit, 'units', 'multi')
				->html($list)
				->get();
	}


	protected static function morphs($items)
	{
		$list =
			MyList::build(Unit::class)
				->pageTitle('Единицы измерения')
				->addButton('ajax')
				->items($items)
				->column(
					ListColumnBuilder::build('id')
						->width('50px')
						->get()
				)
				->column(
					ListColumnBuilder::build('коэфф')
						->width('50px')
						->function(Unit::class, 'multiplier')
						->get()
				)
				->column(
					ListColumnBuilder::build('name')
						->name('Краткое')
						->contenteditable()
						->get()
				)
				->column(
					ListColumnBuilder::build('full_name')
						->contenteditable()
						->name('Полное')
						->get()
				)
				->column(
					ListColumnBuilder::build('code')
						->contenteditable()
						->name('Код')
						->get()
				)
				->del()
				->get();
		return $list;
	}

	public static function editItem($unit): string
	{
		$item =
			ItemBuilder::build($unit, Unit::class)
				->pageTitle('Единицы измерения')
//				->items($unit->units)
				->field(
					ItemFieldBuilder::build('id', $unit)
						->get()
				)
				->tab(
					MorphBuilder::build($unit, 'units', 'multi')
						->html(
							ItemTabBuilder::build('Комплекты')
								->html(self::morphs($unit->units)
								)
						)
				)
				->del()
				->get();
		return $item;

	}

	public static function index(): string
	{
		return MyList::build(Unit::class)
			->pageTitle('Единицы измерения')
			->addButton('ajax')
			->items(Unit::all())
			->column(
				ListColumnBuilder::build('id')
					->width('50px')
					->get()
			)
			->column(
				ListColumnBuilder::build('name')
					->name('Краткое')
					->contenteditable()
					->get()
			)
			->column(
				ListColumnBuilder::build('full_name')
					->contenteditable()
					->name('Полное')
					->get()
			)
			->column(
				ListColumnBuilder::build('code')
					->contenteditable()
					->name('Код')
					->get()
			)
			->del()
			->get();
	}

}