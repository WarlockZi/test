<?php


namespace app\view\Videoinstruction;


use app\model\Videoinstruction;

use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;

class VideoinstructionView
{
	public $model = Videoinstruction::class;
	public $html;

	public static function listAll()
	{
		$view = new self;
        $items = Videoinstruction::all();
		return MyList::build($view->model)
            ->items($items)
			->column(
				ListColumnBuilder::build('sort')
					->width('50px')
					->name('№')
					->sort()
					->contenteditable()
					->get()
			)
			->column(
				ListColumnBuilder::build('name')
					->width('auto')
					->contenteditable()
					->name('Название')
					->get()

			)
			->column(
				ListColumnBuilder::build('link')
					->contenteditable()
					->width('auto')
					->name('Ссылка')
					->get()
			)
			->column(
				ListColumnBuilder::build('tag')
					->contenteditable()
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
			->del()
			->addButton('ajax')
			->get();
	}

}