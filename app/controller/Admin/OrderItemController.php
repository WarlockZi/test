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
			$orderItems = OrderItem::where('sess',$sess)->get();
			$lead = Lead::create($form);
			$order = Order::create($form);
			$order->lead()->associate($lead);
			$order->save();
			foreach ($orderItems as $orderItem){
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
		$model = new $this->model;
		if ($model instanceof Model) {
			$item = $model::where('product_id', $id)->first();
			if ($item) {
//				$destroy = $item->delete();
				$this->exitJson(['ok' => $id, 'popup' => 'Ok']);
			}
		} else {
			if ($model::delete($id)) {
				$this->exitWithPopup('Удален');
			}
		}
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
				['count' => $req['count']]
			);
			$o = $orderItm->toArray();
			$c = $orderItm->wasRecentlyCreated;
		}
		$this->exitJson(['success']);

	}


}
