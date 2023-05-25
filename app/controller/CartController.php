<?php

namespace app\controller;

use app\Actions\CartAction;
use app\core\Auth;
use app\model\Lead;
use app\model\OrderItem;
use app\model\User;
use app\Repository\OrderRepository;

class CartController extends AppController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function actionDrop()
	{
		if (!isset($this->ajax['cartToken'])) exit('No cart sess');
		$id = $this->ajax['cartToken'];
		OrderItem::query()
			->where('sess', $id)
			->delete();

		if (isset($_COOKIE['cartDeadline'])) setcookie('cartDeadline', '', time() - 3600);
		$this->exitJson(['ok' => true]);

	}

	public function actionIndex()
	{
		$lead = Lead::where('sess',session_id())->first();
		$oItems = OrderRepository::main();
		$this->set(compact('oItems','lead'));
	}

	public function actionLogin()
	{
		$req = $this->ajax;

		$user = User::query()
			->where('email', $req['email'])
			->first()
			->toArray();

		if ($user) {
			Auth::setAuth($user);
			CartAction::convertOrderItemsToOrders($req,$user['id']);
			$this->exitJson(['ok' => true]);
		}
		$this->exitJson(['error'=>'Не правильные данные']);
	}


	public function actionLead()
	{
		$req = $this->ajax;

		$lead = Lead::query()
			->updateOrCreate([
				'name' => $req['name'],
				'phone' => $req['phone'],
				'company' => $req['company'],
				'sess' => $req['sess'],
			], [$req]);

		if ($lead->wasRecentlyCreated) {
//			Auth::setAuth($user);
			$this->exitJson(['ok' => true, 'popup' => 'Скоро мы Вам перезвоним!']);
		} else if ($lead->wasChanged()) {
			$this->exitJson(['ok' => true, 'popup' => 'Заказ сохранен!']);
		}
		$this->exitWithError('bad');
	}
}

