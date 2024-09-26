<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\manufacturer;
use app\view\manufacturer\manufacturerView;

class ManufacturerController Extends AppController
{
	public string $model = manufacturer::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex():void
	{
		$manufacturers = ManufacturerView::list($this->model);
		$this->setVars(compact('manufacturers'));
	}

}
