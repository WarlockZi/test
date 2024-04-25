<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\core\Response;
use app\core\Route;
use app\model\Order;
use app\Repository\OrderRepository;
use app\view\Order\OrderView;
use Carbon\Carbon;


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
		$this->set(compact('clientlist', 'leadlist'));
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

		if (!$id) Response::exitWithMsg('No id');
		$model = new $this->model;

		$item = $model->where('product_id', $id)->first();
		if ($item) {
			$destroyed =
				$item::query()
				->update(['deleted_at' => Carbon::today()]);
			Response::exitJson(['ok' => 'ok', 'popup' => 'удален']);
		}
		Response::exitJson(['error' => 'не удален', 'popup' => 'не удален']);
	}


}
