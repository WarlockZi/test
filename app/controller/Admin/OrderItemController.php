<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\core\Route;
use app\model\Lead;
use app\model\Order;
use app\model\OrderItem;
use app\view\Order\OrderView;
use Illuminate\Database\Eloquent\Model;


class OrderItemController Extends AppController
{

	public $model = OrderItem::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionToorder()
	{
		if ($this->ajax) {
			$form = $this->ajax['form'];
			$sess = $_SESSION['token'];
			$orderItems = OrderItem::where('sess', $sess)->get();
			$lead = Lead::create($form);
			$order = Order::create($form);
			$order->lead()->associate($lead);
			$order->save();
			foreach ($orderItems as $orderItem) {
				$orderItem->order()->associate($order);
				$orderItem->save();
			}
			$this->exitJson(['ok']);
		}
	}

	public function actionDelete()
	{
		$id = $this->ajax['id'];

		if (!$id) $this->exitWithMsg('No id');

		if ($this->model::destroy($id)) {
			$this->exitJson(['ok' => true, 'popup' => 'Удален']);
		}
		$this->exitWithPopup('Не удален');

	}

	public function actionIndex()
	{

	}


	public function actionUpdateOrCreate()
	{
		$req = $this->ajax;
		if ($req) {
			$orderItm = OrderItem::updateOrCreate(
				['product_id' => $req['product_id'],
					'sess' => $req['sess'],
				],
				['product_id' => $req['product_id'],
					'sess' => $req['sess'],
					'count' => $req['count'],
					'ip' => $_SERVER['REMOTE_ADDR'],
				]
			);
			$created = $orderItm->wasRecentlyCreated;
			$this->exitJson(['error' => "не записано"]);
		}
		$this->exitJson(['popup' => "ok"]);
	}
}
