<?php

namespace app\controller;

use app\model\Promotion;

class PromotionController Extends AppController
{
	public $model = Promotion::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{
		$promotions = Promotion::with('product.baseUnit')
			->with('product.price')
			->get();
		$this->set(compact('promotions'));
	}

}
