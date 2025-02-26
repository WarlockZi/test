<?php


namespace app\view\Todo;


use app\model\Todo;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;


class TodoView
{

	public static function daily()
	{
		$dailyTodos = Todo::where('type', 'daily')->get();

		return Table::build($dailyTodos)
			->column(
				ColumnBuilder::build('id')
					->name("ID")
					->width('50px')
//					->type('number')
					->sort()
					->get()
			)

			->column(
				ColumnBuilder::build('name')
					->name("Наименование")
					->width('1fr')
					->contenteditable()
					->sort()
					->search()
					->get()
			)
			->column(
				ColumnBuilder::build('description')
					->name("Описание")
					->width('1fr')
					->contenteditable()
					->sort()
					->search()
					->get()
			)

			->column(
				ColumnBuilder::build('post_id')
					->name("Должность")
					->width('1fr')
					->contenteditable()
					->sort()
					->search()
					->get()
			)

			->column(
				ColumnBuilder::build('type')
					->name("Цикличность")
					->width('150px')
					->contenteditable()
					->sort()
					->search()
					->get()
			)
			->edit()
			->del()
			->addButton()
			->get();

	}


}