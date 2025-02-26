<?php

namespace app\controller;

use app\model\Promotion;
use app\Repository\PromotionRepository;

class PromotionController Extends AppController
{
	public string $model = Promotion::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex():void
	{
		$promotions = PromotionRepository::product();

		$this->setVars(compact('promotions'));
		$this->assets->setMeta("Акции", "Акции", "Акции");
	}

}
