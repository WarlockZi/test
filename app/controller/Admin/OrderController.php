<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\core\Route;
use app\Repository\OrderRepository;
use app\view\Order\OrderView;


class OrderController Extends AppController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{
		$orders = OrderRepository::list();
		$list = OrderView::list($orders);
		$this->set(compact('list'));
	}

	public function actionEdit()
	{
		$orderId = $this->route->id;
		$orders = OrderRepository::edit($orderId);
		$this->set(compact('orders'));
	}


}
