<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Country;
use app\view\Country\SupplierView;

class CountryController Extends AppController
{
	public $model = Country::class;

	public function __construct(array $route)
	{
		parent::__construct($route);
	}

	public function actionIndex()
	{
		$countries = Country::all();
		$countries = SupplierView::list($countries);
		$this->set(compact('countries'));
	}

}
