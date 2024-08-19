<?php


namespace app\view\Todo;


use app\model\Todo;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\CustomList;


class TodoView
{

	public static function daily()
	{
		$dailyTodos = Todo::where('type', 'daily')->get();

		return CustomList::build(Todo::class)
			->items($dailyTodos)
			->column(
				ListColumnBuilder::build('id')
					->name("ID")
					->width('50px')
//					->type('number')
					->sort()
					->get()
			)

			->column(
				ListColumnBuilder::build('name')
					->name("Наименование")
					->width('1fr')
					->contenteditable()
					->sort()
					->search()
					->get()
			)
			->column(
				ListColumnBuilder::build('description')
					->name("Описание")
					->width('1fr')
					->contenteditable()
					->sort()
					->search()
					->get()
			)

			->column(
				ListColumnBuilder::build('post_id')
					->name("Должность")
					->width('1fr')
					->contenteditable()
					->sort()
					->search()
					->get()
			)

			->column(
				ListColumnBuilder::build('type')
					->name("Цикличность")
					->width('150px')
					->contenteditable()
					->sort()
					->search()
					->get()
			)
			->edit()
			->del()
			->addButton('ajax')
			->get();

	}


}