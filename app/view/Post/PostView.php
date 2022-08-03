<?php


namespace app\view\Post;


use app\model\Post;

use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use app\view\MyView;


class PostView extends MyView
{

	public $model = Post::class;
	public $html;

	public static function listAll(): string
	{
		$view = new self;
		return MyList::build($view->model)
			->column(
				ListColumnBuilder::build('id')
					->name('ID')
					->get()
			)

			->column(
				ListColumnBuilder::build('name')
					->name('Наименование')
					->contenteditable(true)
					->search(true)
					->width('1fr')
					->get()
			)
			->column(
				ListColumnBuilder::build('full_name')
					->name('Полное наим')
					->contenteditable(true)
					->search(true)
					->width('1fr')
					->get()
			)
			->all()
			->edit()
			->del()
			->addButton('ajax')
			->get();
	}

}