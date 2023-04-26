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
		if (!isset($_COOKIE['cart'])) {
			$digit = 10;
			$unit = 'm';
			$value = time()+Cookie::getTime($digit, $unit);
			Cookie::set('cart', $value, $digit, $unit);
		}

		if (!Auth::getUser()) {
			Error::setError('Чтобы мы смогли выставить вам счет введите имя и телефон');
		}

		$oItems = OrderRepository::main();
		$this->set(compact('oItems'));

	}
}

