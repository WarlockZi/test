<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Response;
use app\core\Router;
use app\Factory\AbstractTestFactory;
use app\Factory\TestFactory;
use app\model\Question;
use app\model\Test;
use app\Repository\TestRepository;
use app\Services\Test\TestDoService;
use app\Services\Test\TestEditService;


class QuestionController Extends AppController
{
	protected $model = Question::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionEdit()
	{
		$id = Router::getRoute()->id;
		if ($id) {
			$test = new TestEditService();

			$page_name = 'Редактирование тестов';
			$this->set(compact('page_name'));

			$this->set(compact('test'));
		}
	}

	public function actionSort()
	{
		$q_ids = $this->ajax['toChange'];
		Question::sort($q_ids);
		Response::exitWithPopup('Сортировка сохранена');
	}

}
