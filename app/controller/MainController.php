<?php

namespace app\controller;

use app\core\Base\View;
use app\core\App;

class MainController Extends AppController
{

	public function __construct($route)
	{

		if ($this->isAjax()) {
			if (isset($_POST['param'])) {
				$arr = json_decode($_POST['param'], true);
				$func = $arr['action'];
				$model = $arr['model'] ?: 'adminsc';
				if (App::$app->{$model}->$func($arr)) {
					exit(true);
				}
			}
		}
		parent::__construct($route);

		$sale = App::$app->cache->get('sale');
		if (!$sale) {
			$sale = App::$app->product->getSale();
			App::$app->cache->set('sale', $sale, 30);
		}

		$this->set(compact('sale'));
	}

	public function actionIndex()
	{
		if (isset($_SESSION['id'])) {
			$user = App::$app->user->getUser($_SESSION['id']);
			if ($user === false) {
				$errors[] = 'Неправильные данные для входа на сайт';
			} elseif ($user === NULL) {
				$errors[] = 'Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
			} else {
				$this->set(compact('user'));
			}
		}
			View::setMeta('Медицинские расходные материалы', 'Доставим медицинские расходные материалы в любую точку России', 'медицинские расходные материалы, доставка, производство, по России');
			View::setCss(['css' => '/public/build/mainIndex.css']);
			View::setJs(['js' => '/public/build/mainIndex.js']);
	}

	public function actionPoliticaconf()
	{
		View::setCss(['css' => '/public/build/mainIndex.css']);
	}

	public function actionDiscount()
	{
		View::setCss(['css' => '/public/build/mainIndex.css']);
	}

	public function actionDelivery()
	{
		View::setCss(['css' => '/public/build/mainIndex.css']);
	}

	public function actionPayment()
	{
		View::setCss(['css' => '/public/build/mainIndex.css']);
	}

	public function actionContacts()
	{
		View::setCss(['css' => '/public/build/mainIndex.css']);
	}

	public function actionOferta()
	{
		View::setCss(['css' => '/public/build/mainIndex.css']);
	}

	public function actionAbout()
	{
		View::setCss(['css' => '/public/build/mainIndex.css']);
	}

	public function actionReturn_change()
	{

	}

	public function actionArticles()
	{
		View::setCss(['css' => '/public/build/mainIndex.css']);
	}

}
