<?php

namespace app\controller;

use app\model\Answer;
use app\model\Question;
use app\model\Test;
use app\model\Question as oldQest;


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

		$id = isset($this->route['id']) ? (int)$this->route['id'] : 0;
		if ($id) {
//			$test = Test::find($id);

//			if ($test) {
//				if ($test->isTest) {
			$test
				= Test::with('questions.answers')
				->orderBy('sort')
				->find($id)->toArray();
//					if (!$questions) {
//						$id = oldQest::create(['parent' => $id]);
//						$question = oldQest::findOneWhere('id', $id - 1);
//						$this->set(compact('question'));
//
//						$tests = oldTest::findAllWhere('isTest', '1');
//						$this->set(compact('tests'));
////					}
//				} else {
//					$test['children'] = Test::findAllWhere('parent', $id);;
//				}
			$parentSelector = \app\view\Test\TestView::questionParentSelector($test['id']);

			$this->set(compact('test'));
			$this->set(compact('parentSelector'));

		}
	}


	public function actionChangeParent()
	{
		if ($ids = $this->ajax) {
			$id = $ids['id'];
			$testId = $ids['test_id'];
			$q = oldQest::findOneWhere('id', $id);
			$q['parent'] = $testId;
			oldQest::update($q)
				? $this->exitWithPopup('ok')
				: $this->exitWithError('Ошибка при переносе вопроса');
		}
	}


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

	public function actionImage()
	{
		$q_id = $this->ajax['q_id'];

		$answers = Answer::findOneWhere('question_id', $q_id);
		foreach ($answers as $answer) {
			Answer::delete($answer['id']);
		}
		oldQest::delete($q_id);
		exit(json_encode(['msg' => 'ok', 'q_id' => $q_id]));
	}

	public function actionSort()
	{
		$q_ids = $this->ajax['toChange'];
		Question::sort($q_ids);
		$this->exitWithPopup('Сортировка сохранена');
	}

}
