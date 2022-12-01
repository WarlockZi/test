<?php


namespace app\view\Order;


use app\model\Order;

use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use app\view\MyView;


abstract class OrderView extends MyView
{

	public $model = Order::class;
	public $html;

	public static function listAll(): string
	{
		return MyList::build(Order::class)
			->column(
				ListColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ListColumnBuilder::build('name')
					->name('Наименование')
					->search(true)
					->width('1fr')
					->get())
			->all()
			->edit()
			->get();
	}

}