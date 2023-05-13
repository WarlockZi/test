<?php

namespace app\controller;

use app\core\Auth;
use app\core\Cookie;
use app\core\Error;
use app\model\OrderItem;
use app\Repository\OrderRepository;

class CartController extends AppController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function actionDrop()
	{
		if (isset($this->ajax['cartToken'])) {
			$id = $this->ajax['cartToken'];
			OrderItem::where('sess', $id)
				->delete();

			$this->exitJson(['ok'=>true]);
		}
	}


	public function actionIndex()
	{

		if (isset($_COOKIE['cartCounter'])) setcookie('cartCounter','', time()-3600);
		if (isset($_COOKIE['cartDeadline'])) setcookie('cartDeadline','', time()-3600);
		if (isset($_COOKIE['cart'])) setcookie('cart','', time()-3600);

		if (!Auth::getUser()) {
			Error::setError('Чтобы мы смогли выставить вам счет введите имя и телефон');
		}

		$oItems = OrderRepository::main();
		$this->set(compact('oItems'));

	}
}

