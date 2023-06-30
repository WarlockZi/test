<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Promotion;
use app\view\Promotion\PromotionFormView;

class PromotionController Extends AppController
{
	public $model = Promotion::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionEdit()
	{
		$id = $this->route->id;
		$promotion = Promotion::with('product')->find($id);
		$promotion = PromotionFormView::edit($promotion);
		$this->set(compact('promotion'));
	}
	public function actionIndex()
	{
		$promotions = Promotion::with('product')->get();
		$promotions = PromotionFormView::adminIndex($promotions);
		$this->set(compact('promotions'));
	}
}
