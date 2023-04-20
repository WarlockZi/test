<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\core\Route;
use app\model\OrderItem;
use app\view\Order\OrderView;


class OrderItemController Extends AppController
{

	public $model = OrderItem::class;

	public function __construct()
	{
		parent::__construct();

	}

	public function actionIndex()
	{

	}


	public function actionUpdateOrCreate()
	{
		$req = $this->ajax;
		if ($req) {
			$req['sess'] = session_id();

			$orderItm = OrderItem::updateOrCreate(
				['sess' => $req['sess'], 'product_id' => $req['product_id']],
				['count'=>$req['count']]
			);
			$o = $orderItm->toArray();
			$c = $orderItm->wasRecentlyCreated;
		}
		$this->exitJson(['success']);

	}


}
