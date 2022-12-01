<?php


namespace app\view\Tag;


use app\model\Tag;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;

class TagView
{

	public static function list($tags)
	{
		return MyList::build(Tag::class)
			->pageTitle('Тэги')
			->del()
			->addButton('ajax')

			->items($tags->toArray())
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