<?php


namespace app\view\Order;


use app\model\Order;

use app\model\OrderItem;
use app\model\User;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use app\view\MyView;


abstract class OrderView
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
					->search()
					->width('1fr')
					->get())
			->all()
			->edit()
			->get();
	}

	public static function leadList($items): string
	{
		return MyList::build(Order::class)
			->column(
				ListColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ListColumnBuilder::build('user')
					->function(OrderItem::class, 'leadData')
					->name('Клиент')
					->search()
					->width('1fr')
					->get())
			->items($items)
			->edit()
			->get();
	}

	public static function clientList($items): string
	{
		return MyList::build(Order::class)
			->column(
				ListColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ListColumnBuilder::build('user')
					->function(Order::class, 'userEmail')
					->name('Клиент')
					->search()
					->width('1fr')
					->get())
			->items($items)
			->edit()
			->get();
	}
//	public static function edit($orders)
//	{
//		return 	include __DIR__.'/Admin/edit.php';
//
//	}

}