<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Question;
use app\model\Test;


class QuestionController Extends AppController
{
	public $model = Question::class;

	public function __construct(array $route)
	{
		parent::__construct($route);
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


//	public function actionChangeParent()
//	{
//		if ($ids = $this->ajax) {
//			$id = $ids['id'];
//			$testId = $ids['test_id'];
//			$q = oldQest::findOneWhere('id', $id);
//			$q['parent'] = $testId;
//			oldQest::update($q)
//				? $this->exitWithPopup('ok')
//				: $this->exitWithError('Ошибка при переносе вопроса');
//		}
//	}


//	public function actionDelete()
//	{
//		$q_id = $this->ajax['id'];
//
//		$answers = Answer::findAllWhere('question_id', $q_id);
//		foreach ($answers as $answer) {
//			Answer::delete($answer['id']);
//		}
//		oldQest::delete($q_id);
//		$this->exitWithPopup('Вопрос и ответы удалены');
//	}

}
