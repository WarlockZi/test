<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Country;
use app\view\Country\CountryView;

class CountryController Extends AdminscController
{
	public string $model = Country::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex():void
	{

		$countries = CountryView::list($this->model);
		$this->setVars(compact('countries'));
	}

}
