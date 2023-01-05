<?php


namespace app\view\Planning;


use app\model\Todo;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use Illuminate\Database\Eloquent\Collection;


class PlanningView
{

	public $modelName = Todo::class;

	public static function list(Collection $items): string
	{
		$view = new self;
		return MyList::build($view->modelName)
			->items($items)
			->column(
				ListColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ListColumnBuilder::build('name')
					->name('Наименование')
					->sort()
					->contenteditable()
					->search()
					->width('1fr')
					->get())
			->all()
			->edit()
			->get();
	}

}