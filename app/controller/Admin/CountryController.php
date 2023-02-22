<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Country;
use app\view\Country\CountryView;

class CountryController Extends AppController
{
	public $model = Country::class;

	public function __construct(array $route)
	{
		parent::__construct();
	}

	public function actionIndex()
	{

		$countries = CountryView::list($this->model);
		$this->set(compact('countries'));
	}

}
