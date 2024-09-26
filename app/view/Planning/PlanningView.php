<?php


namespace app\view\Planning;


use app\model\Todo;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;


class PlanningView
{
	public static function listDaily(): string
	{
		$items = Todo::where('type','день')->get();
		return Table::build($items)
            ->model('todo')
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
			->edit()
			->get();
	}
	public static function listWeekly(): string
	{
		$items = Todo::where('type','неделя')->get();
		return Table::build($items)
            ->model('todo')
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
			->edit()
			->get();
	}
	public static function listYearly(): string
	{
		$items = Todo::where('type','год')->get();
		return Table::build($items)
            ->model('todo')
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