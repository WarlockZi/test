<?php

namespace app\controller;

use app\Actions\CartAction;
use app\Actions\Helpers;
use app\core\Auth;
use app\core\Icon;
use app\core\Response;
use app\model\Lead;
use app\model\OrderItem;
use app\model\User;
use app\Repository\CartRepository;
use app\Repository\OrderRepository;
use app\view\Cart\CartView;

class CartController extends AppController
{
    protected CartView $cartView;
	public function __construct()
	{
		parent::__construct();
        $this->cartView = new CartView();
	}

	public function actionDrop()
	{
		if (!isset($this->ajax['cartToken'])) exit('No cart sess');
		$id = $this->ajax['cartToken'];
		OrderItem::query()
			->where('sess', $id)
			->delete();
		if (isset($_COOKIE['cartDeadline'])) setcookie('cartDeadline', '', time() - 3600);
		Response::exitJson(['ok' => true]);

	}

	public function actionIndex():void
	{
        $s =  session_id();
		$lead = Lead::where('sess',$s)->first();
		$products = CartRepository::main();
        $authed = Auth::isAuthed();
        $trashedWhite = Icon::trashWhite();

		$this->set(compact('products', 'lead','authed', 'trashedWhite'));
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
			CartAction::convertOrderItemsToOrders($req, $user['id']);
			Response::exitJson(['ok' => true]);
		}
		Response::exitJson(['error' => 'Не правильные данные']);
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

		if ($lead->wasChanged()) {
			Response::exitJson(['ok' => true, 'popup' => 'Заказ сохранен!']);
		}
		Response::exitJson(['ok' => true, 'popup' => 'Скоро мы Вам перезвоним!']);
	}
}

