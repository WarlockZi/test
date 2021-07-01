<?php

namespace app\controller;

use app\view\View;
use app\core\App;

class MainController Extends AppController
{

	public function __construct($route)
	{

//		if ($this->isAjax()) {
//			if (isset($_POST['param'])) {
//				$arr = json_decode($_POST['param'], true);
//				$func = $arr['action'];
//				$model = $arr['model'] ?: 'adminsc';
//				if (App::$app->{$model}->$func($arr)) {
//					exit(true);
//				}
//			}
//		}

		parent::__construct($route);

		$sale = App::$app->cache->get('sale');
		if (!$sale) {
			$sale = App::$app->product->getSale();
			App::$app->cache->set('sale', $sale, 30);
		}

		$this->set(compact('sale'));
			View::setCss('main.css');
			View::setJs('main.js');

	}

	public function actionIndex()
	{
		if (isset($_SESSION['id'])) {
			$user = App::$app->user->get($_SESSION['id']);
			if ($user === false) {
				$errors[] = 'Неправильные данные для входа на сайт';
			} elseif ($user === NULL) {
				$errors[] = 'Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
			} else {
				$this->set(compact('user'));
			}
		}
			View::setMeta('Медицинские расходные материалы', 'Доставим медицинские расходные материалы в любую точку России', 'медицинские расходные материалы, доставка, производство, по России');
	}

	public function actionPoliticaconf()
	{
	}

	public function actionDiscount()
	{
	}

	public function actionDelivery()
	{
	}

	public function actionPayment()
	{
	}

	public function actionContacts()
	{
	}

	public function actionOferta()
	{
	}

	public function actionAbout()
	{
	}

	public function actionReturn_change()
	{
	}

	public function actionArticles()
	{
	}

}
