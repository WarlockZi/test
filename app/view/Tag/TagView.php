<?php


namespace app\view\Tag;

use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\CustomList;

class TagView
{

	public static function list(string $className)
	{
		return CustomList::build($className)
			->pageTitle('Тэги')
			->del()
			->addButton('ajax')
			->all()
			->column(
				ListColumnBuilder::build('id')
					->get()
			)
			->column(
				ListColumnBuilder::build('name')
					->search()
					->contenteditable()
					->get()
			)
			->get();


	}

}