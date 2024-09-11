<?php


namespace app\view\Planning;


use app\model\Todo;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
use Illuminate\Database\Eloquent\Collection;


class PlanningView
{

	public $modelName = Todo::class;

	public static function listDaily(): string
	{
		$view = new self;
		$items = Todo::where('type','день')->get();
		return Table::build($view->modelName)
			->items($items)
			->column(
				ColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ColumnBuilder::build('name')
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
		return Table::build($view->modelName)
			->items($items)
			->column(
				ColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ColumnBuilder::build('name')
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
		return Table::build($view->modelName)
			->items($items)
			->column(
				ColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ColumnBuilder::build('name')
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