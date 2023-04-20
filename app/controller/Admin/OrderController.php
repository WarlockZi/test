<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\core\Route;
use app\view\Order\OrderView;


class OrderController Extends AppController
{
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
