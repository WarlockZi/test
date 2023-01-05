<?php


namespace app\controller\Admin;


use app\controller\AppController;
use app\model\Unit;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;

class UnitController extends AppController
{
	public $model = Unit::class;

	public function actionIndex()
	{
//		$u = Unit::all()->toArray();
		$units = MyList::build(Unit::class)
			->pageTitle('Единицы измерения')
			->addButton('ajax')
			->del()
			->items(Unit::all())
			->column(
				ListColumnBuilder::build('id')
					->width('50px')
					->get()
			)
			->column(
				ListColumnBuilder::build('name')
					->name('Краткое')
					->contenteditable()
					->get()
			)
			->column(
				ListColumnBuilder::build('full_name')
					->contenteditable()
					->name('Полное')
					->get()
			)
			->get();

		$this->set(compact('units'));
	}

}