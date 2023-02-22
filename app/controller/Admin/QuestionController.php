<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Route;
use app\model\Question;
use app\model\Test;


class QuestionController Extends AppController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function actionEdit()
	{
		$page_name = 'Редактирование тестов';
		$this->set(compact('page_name'));

		if (isset($this->route['id'])) {
			$id = (int)$this->route['id'] ?? 0;
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
