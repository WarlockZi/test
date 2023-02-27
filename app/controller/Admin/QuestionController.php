<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Router;
use app\model\Question;
use app\model\Test;


class QuestionController Extends AppController
{
	protected $model = Question::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionEdit()
	{
		$page_name = 'Редактирование тестов';
		$this->set(compact('page_name'));

		$id = Router::getRoute()->id;

		if ($id) {
			$test = Test::with('questions.answers')
				->orderBy('sort')
				->find($id);

			$this->set(compact('test'));
		}
	}

	public function actionSort()
	{
		$q_ids = $this->ajax['toChange'];
		Question::sort($q_ids);
		$this->exitWithPopup('Сортировка сохранена');
	}

}
