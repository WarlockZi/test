<?php


namespace app\view\Planning;


use app\model\Todo;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\CustomList;
use Illuminate\Database\Eloquent\Collection;


class PlanningView
{

	public $modelName = Todo::class;

	public static function listDaily(): string
	{
		$view = new self;
		$items = Todo::where('type','день')->get();
		return CustomList::build($view->modelName)
			->items($items)
			->column(
				ListColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ListColumnBuilder::build('name')
					->name('Наименование')
					->sort()
					->contenteditable()
					->search()
					->width('1fr')
					->get())
//			->all()
			->edit()
			->get();
	}
	public static function listWeekly(): string
	{
		$view = new self;
		$items = Todo::where('type','неделя')->get();
		return CustomList::build($view->modelName)
			->items($items)
			->column(
				ListColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ListColumnBuilder::build('name')
					->name('Наименование')
					->sort()
					->contenteditable()
					->search()
					->width('1fr')
					->get())
//			->all()
			->edit()
			->get();
	}
	public static function listYearly(): string
	{
		$view = new self;
		$items = Todo::where('type','год')->get();
		return CustomList::build($view->modelName)
			->items($items)
			->column(
				ListColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ListColumnBuilder::build('name')
					->name('Наименование')
					->sort()
					->contenteditable()
					->search()
					->width('1fr')
					->get())
//			->all()
			->edit()
			->get();
	}


}