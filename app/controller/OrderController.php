<?php

namespace app\controller;


use app\model\Order;
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
		$list = OrderView::listAll();
		$this->set(compact('list'));
	}






}
