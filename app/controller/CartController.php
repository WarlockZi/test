<?php

namespace app\controller;

use app\core\Auth;
use app\core\Cookie;
use app\core\Error;
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
		if (!Auth::getUser()) {
			Error::setError('Чтобы мы смогли выставить вам счет введите имя и телефон');
		}
		$oItems = OrderRepository::main();
		$this->set(compact('oItems'));
	}

	public function actionLogin()
	{
		if (!isset($this->ajax['email']) || !isset($this->ajax['password'])) $this->exitWithError('Bad data');
		$user = User::where('email', $this->ajax['email'])
			->where('password', $this->ajax['password'])
			->first();

		if ($user) {
			Auth::setAuth($user);
			$this->exitJson(['ok'=>true]);
		}
	}
}

