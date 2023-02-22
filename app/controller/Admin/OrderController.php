<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\core\Route;
use app\view\Order\OrderView;


class OrderController Extends AppController
{
//	public $modelName = 'order';
//	public $model = Order::class;
//	public $table = 'orders';

	public function __construct()
	{
		parent::__construct();

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
