<?php


namespace app\view\Videoinstruction;


use app\model\Videoinstruction;

use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class VideoinstructionView
{
	public $model = Videoinstruction::class;
	public $html;

	public static function listAll()
	{
		$view = new self;
        $items = Videoinstruction::all();
		return Table::build($items)
			->column(
				ColumnBuilder::build('sort')
					->width('50px')
					->name('№')
					->sort()
					->contenteditable()
					->get()
			)
			->column(
				ColumnBuilder::build('name')
					->width('auto')
					->contenteditable()
					->name('Название')
					->get()

			)
			->column(
				ColumnBuilder::build('link')
					->contenteditable()
					->width('auto')
					->name('Ссылка')
					->get()
			)
			->column(
				ColumnBuilder::build('tag')
					->contenteditable()
					->width('auto')
					->name('Группа')
					->get()
			)
			->column(
				ColumnBuilder::build('user_id')
					->width('50px')
					->name('Польз')
					->get()
			)
			->del()
			->addButton()
			->get();
	}

}