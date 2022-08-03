<?php

namespace app\controller;

use app\model\Order;
use app\view\Order\OrderView;
use app\view\View;


class OrderController Extends AppController
{
	protected $modelName = 'order';
	protected $model = Order::class;
	protected $table = 'orders';

	public function __construct(array $route)
	{
		parent::__construct($route);

	}

	public function actionIndex()
	{
		$list = OrderView::listAll();
		$this->set(compact('list'));
	}

	public function actionCreate()
	{
		if ($this->ajax) {
			if ($id = $this->modelClass::create($this->ajax)) {
				$this->exitJson(['id' => $id,]);
			}
		}
	}

	public function actionUpdateOrCreate()
	{
		if ($this->ajax) {
		}
	}



}
