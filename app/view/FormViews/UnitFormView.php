<?php


namespace app\view\FormViews;


use app\model\Unit;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use app\view\components\Builders\Morph\MorphBuilder;

class UnitFormView
{

	public static function edit($morpUnits): string
	{
		$list =
			MyList::build(Unit::class)
				->pageTitle('Единицы измерения')
				->addButton('ajax')
				->items($morpUnits->units)
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
		return
			MorphBuilder::build($morpUnits->first(), 'units', 'multi')
				->html($list)
				->get();

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