<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Supplier;
use app\view\Supplier\SupplierView;

class SupplierController Extends AppController
{
	public $model = Supplier::class;

	public function __construct(array $route)
	{
		parent::__construct($route);
	}

	public function actionIndex()
	{
		$suppliers = SupplierView::list($this->model);
		$this->set(compact('suppliers'));
	}

}
