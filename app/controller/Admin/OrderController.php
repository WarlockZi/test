<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\core\Route;
use app\model\Order;
use app\Repository\OrderRepository;
use app\view\Order\OrderView;


class OrderController Extends AppController
{
	public $model = Order::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{
		$orderItems = OrderRepository::leadList();
		$leadlist = OrderView::leadList($orderItems);
		$orders = OrderRepository::clientList();
		$clientlist = OrderView::clientList($orders);
		$this->set(compact('clientlist','leadlist'));
	}

	public function actionEdit()
	{
		$orderId = $this->route->id;
		$orders = OrderRepository::edit($orderId);
		$this->set(compact('orders'));
	}


	public function actionDelete()
	{
		$id = $this->ajax['product_id'];

		if (!$id) $this->exitWithMsg('No id');
		$model = new $this->model;

		$item = $model->where('product_id', $id)->first();
		if ($item) {
			$destroyed = $item->delete();
			$this->exitJson(['ok' => 'ok', 'popup' => 'удален']);
		}
		$this->exitJson(['error' => 'не удален', 'popup' => 'не удален']);
	}


}
