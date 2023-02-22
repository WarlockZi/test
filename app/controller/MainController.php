<?php

namespace app\controller;

use app\view\View;

class MainController extends AppController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{
//		View::setMeta('Нитриловые перчатки оптом', 'Доставим нитриловые перчатки, бахилы, маски по России. Оптом.', 'нитриловые перчатки, бахилы, маски, расходные материалы, доставка, производство, по России');
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
