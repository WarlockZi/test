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
		$this->assets->setMeta('Нитриловые перчатки оптом', 'Доставим нитриловые перчатки, бахилы, маски по России. Оптом.', 'нитриловые перчатки, бахилы, маски, расходные материалы, доставка, производство, по России');
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
		$this->assets->setMeta('Контакты', 'Контакты', 'Контакты');
	}

	public function actionOferta()
	{
	}

	public function actionAbout()
	{
	}

	public function actionReturnChange()
	{
//		$this->setView();
	}

	public function actionArticles()
	{
	}

	public function actionNews()
	{
		$content = 'Следите за новостями)';
		$this->set(compact('content'));
	}

}
