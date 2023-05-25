<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\core\Auth;
use app\model\Lead;
use app\model\Order;
use app\model\OrderItem;


class OrderitemController Extends AppController
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
		$product_id = $this->ajax['product_id'];
		$sess = $this->ajax['sess'];

		if (!$product_id) $this->exitWithMsg('No id');
		$orderItem = $this->model::query()
			->where('sess', $sess)
			->where('product_id', $product_id)
			->first()
			->forceDelete();
		if ($orderItem->trashed) {
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
			if (Auth::isAuthed()) {
				$orderItm = Order::updateOrCreate(
					['product_id' => $req['product_id'],
						'sess' => $req['sess'],
					],
					['product_id' => $req['product_id'],
						'sess' => $req['sess'],
						'count' => $req['count'],
						'ip' => $_SERVER['REMOTE_ADDR'],
						'user_id' => Auth::getUser()['id'],
					]
				);
			} else {
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
			}
			if ($orderItm->wasRecentlyCreated) {
				$this->exitJson(['popup' => "Добавлено в корзину"]);
			}
			if ($orderItm->wasChanged()) {
				$this->exitJson(['popup' => "Изменено"]);
			}
			$this->exitJson(['error' => "не записано"]);
		}

	}
}
