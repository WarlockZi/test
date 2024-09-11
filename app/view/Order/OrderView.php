<?php


namespace app\view\Order;


use app\model\Order;

use app\model\OrderItem;
use app\model\User;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
use app\view\MyView;


abstract class OrderView
{

	public $model = Order::class;
	public $html;

	public static function listAll(): string
	{
		return Table::build(Order::all())
            ->model('order')
			->column(
				ColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ColumnBuilder::build('name')
					->name('Наименование')
					->search()
					->width('1fr')
					->get())
			->edit()
			->get();
	}

	public static function leadList($items): string
	{
		$list =  Table::build($items)
            ->model('order')
			->column(
				ColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ColumnBuilder::build('user')
					->function(OrderItem::class, 'leadData')
					->name('Клиент')
					->search()
					->width('1fr')
					->get())
			->edit()
			->get();
        return $list;
	}

	public static function clientList($items): string
	{
		return Table::build(Order::all())
            ->model('order')
			->column(
				ColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ColumnBuilder::build('user')
					->function(Order::class, 'userEmail')
					->name('Клиент')
					->search()
					->width('1fr')
					->get())
			->edit()
			->addButton('ajax')
			->get();
	}
//	public static function edit($orders)
//	{
//		return 	include __DIR__.'/Admin/edit.php';
//
//	}

}