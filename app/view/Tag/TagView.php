<?php


namespace app\view\Tag;

use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;

class TagView
{

	public static function list(string $className)
	{
		return MyList::build($className)
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