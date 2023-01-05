<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\manufacturer;
use app\view\manufacturer\manufacturerView;

class ManufacturerController Extends AppController
{
	public $model = manufacturer::class;

	public function __construct(array $route)
	{
		parent::__construct($route);
	}

	public function actionIndex()
	{
		$manufacturers = ManufacturerView::list($this->model);
		$this->set(compact('manufacturers'));
	}

}
