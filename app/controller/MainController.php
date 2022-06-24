<?php

namespace app\controller;

use app\view\View;
use app\model\Product;
use app\core\Cache;

class MainController extends AppController
{

	public function __construct($route)
	{

		parent::__construct($route);

		$this->auth();
			$sale = Product::getSale();
		$this->set(compact('sale'));
		View::setCss('main.css');
		View::setJs('main.js');

	}

	public function actionIndex()
	{
		View::setMeta('Нитриловые перчатки оптом', 'Доставим нитриловые перчатки, бахилы, маски по России. Оптом.', 'нитриловые перчатки, бахилы, маски, расходные материалы, доставка, производство, по России');
	}

	public function actionPoliticaconf()
	{
	}
	public function actionRequisites()
	{
//		$this->view = '';
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
		View::setMeta('Задайте вопрос', 'Задайте вопрос', 'Задайте вопрос');
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
