<?php

namespace app\controller;

use app\core\App;
use app\model\Answer;
use app\model\Question;


class QuestionController Extends AppController
{

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->autorize();
	}

	public function actionUpdateOrCreate()
	{
		if ($this->ajax) {
			try {
				$question = $this->ajax;
				$qId = Question::updateOrCreate($question);
				if ($qId === false) {
					$this->exitWithPopup('Ощибка');
				} elseif (is_int($qId)) {
					$this->exitJson(['id' => $qId]);
				} elseif ($qId === true) {
					$this->exitWithPopup('Вопрос сохранен');
				}

			} catch (Exception $exception) {
				exit($exception->getMessage());
			};
		}
	}

	public function actionChangeParent()
	{
		if ($ids = $this->ajax) {
			$id = $ids['id'];
			$testId = $ids['test_id'];
			$q = Question::findOneWhere('id', $id);
			$q['parent'] = $testId;
			Question::update($q)
				?$this->exitWithPopup('ok')
				:$this->exitWithError('Ошибка при переносе вопроса');
		}
	}


	public function actionUpdate()
	{
		Question::updateOrCreate($this->ajax['question']);

		foreach ($this->ajax['answers'] as $answer) {
			Answer::updateOrCreate($answer);
		}
		exit(json_encode(['msg' => 'Saved']));
	}

	public function actionDelete()
	{
		$q_id = $this->ajax['id'];

		$answers = Answer::findAllWhere('question_id', $q_id);
		foreach ($answers as $answer) {
			Answer::delete($answer['id']);
		}
		Question::delete($q_id);
		$this->exitWithPopup('Вопрос и ответы удалены');
	}

	public function actionImage()
	{
		$q_id = $this->ajax['q_id'];

		$answers = Answer::findOneWhere('question_id', $q_id);
		foreach ($answers as $answer) {
			Answer::delete($answer['id']);
		}
		Question::delete($q_id);
		exit(json_encode(['msg' => 'ok', 'q_id' => $q_id]));
	}

	public function actionSort()
	{
		$q_ids = $this->ajax['toChange'];
		Question::sort($q_ids);
		$this->exitWithPopup('Сортировка сохранена');
	}

}
