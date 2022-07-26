<?php


namespace app\view\Videoinstruction;


use app\model\Videoinstruction;
use app\view\components\Builders\ListColumnBuilder;
use app\view\components\MyList\MyList;
use app\view\MyView;

class VideoinstructionView extends MyView
{
	public $model = Videoinstruction::class;
	public $html;

	public static function listAll()
	{

		$view = new self;
		return MyList::build($view->model)
			->all()
			->column(
				ListColumnBuilder::build('sort')
					->width('50px')
					->name('№')
					->sort(true)
					->contenteditable(true)
					->get()
			)
			->column(
				ListColumnBuilder::build('name')
					->width('auto')
					->contenteditable(true)
					->name('Название')
					->get()

			)
			->column(
				ListColumnBuilder::build('link')
					->contenteditable(true)
					->width('auto')
					->name('Ссылка')
					->get()
			)
			->column(
				ListColumnBuilder::build('tag')
					->contenteditable(true)
					->width('auto')
					->name('Группа')
					->get()
			)
			->column(
				ListColumnBuilder::build('user_id')
					->width('50px')
					->name('Польз')
					->get()
			)
			->edit()
			->addButton('ajax')
			->get();
	}

}