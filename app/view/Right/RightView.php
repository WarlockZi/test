<?php

namespace app\view\Right;

use app\model\Right;
use app\view\components\Builders\ListColumnBuilder;
use app\view\components\MyList\MyList;
use app\view\MyView;

class RightView extends MyView
{
	public $model = Right::class;
	public $html;

	public static function listAll(): string
	{
		$view = new self;
		return MyList::build($view->model)
			->column(
				ListColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ListColumnBuilder::build('name')
					->name('Право')
					->search(true)
					->contenteditable(true)
					->sort(true)
					->width('1fr')
					->get())
			->column(
				ListColumnBuilder::build('description')
					->name('Описание')
					->contenteditable(true)
					->search(true)
					->width('1fr')
					->get()
			)
			->addButton('ajax')
			->del()
			->all()
			->get();
	}

}