<?php


namespace app\view\Tag;

use app\model\Tag;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class TagView
{

	public static function list(string $className)
	{
		return Table::build(Tag::all())
			->pageTitle('Тэги')
			->del()
			->addButton()
			->column(
				ColumnBuilder::build('id')
					->get()
			)
			->column(
				ColumnBuilder::build('name')
					->search()
					->contenteditable()
					->get()
			)
			->get();


	}

}