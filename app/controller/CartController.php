<?php

namespace app\controller;

use app\core\Auth;
use app\core\Error;
use app\Repository\OrderRepository;
use \app\view\View;

class CartController extends AppController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{

		if (!Auth::getUser()) {
			Error::setError('Чтобы мы смогли выставить вам счет введите имя и телефон');
		}

		$oItems = OrderRepository::main();
		$this->set(compact('oItems'));


	}

}

