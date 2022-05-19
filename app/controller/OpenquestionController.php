<?php

namespace app\controller;

use app\core\App;
use app\model\Openanswer;
use app\model\Openquestion;


class OpenquestionController Extends AppController
{
	private $req;
	private $model = 'Openquestion';

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->autorize();
	}

	public function actionShow()
	{
	}

	public function actionUpdateOrCreate()
	{
		try {
			$answers = $this->req['answers'] ?? '';
			$question = $this->req['question'] ?? '';
			$q_id = $this->req['question']['id'] ?? '';
			$sort = $this->req['question']['sort'] ?? '';
			$qId = $this->model::updateOrCreate($question);
			if ($qId === false) {
				return;
			} elseif (is_int($qId)) {
				if ($answers) {
					foreach ($answers as $answer) {
						$answer['parent_question'] = $qId;
						Openanswer::updateOrCreate($answer);
					}
				}
				exit(json_encode([
					'id' => $qId,
					'msg' => 'Вопросы и ответы сохранены',
					'paginationButton' => $pagination = "<div data-pagination = $q_id class='nav-active'>{$sort}</div>"
				]));
			} elseif ($qId === true) {
				foreach ($answers as $answer) {
					Openanswer::updateOrCreate($answer);
				}
				exit(json_encode([
					'msg' => 'Вопросы и ответы сохранены']));
			}

		} catch (Exception $exception) {
			exit($exception->getMessage());
		};
	}

	public function actionChangeParent()
	{
		if ($ids = $this->ajax) {
			$id = $ids['id'];
			$testId = $ids['test_id'];
			$q = $this->model::where('id',$id)
				->get();
			$q['parent'] = $testId;
			$this->model::update($q);
			exit(json_encode(['msg' => 'ok']));
		}
	}

public function actionUpdate()
	{
		$this->model::updateOrCreate($this->req['question']);

		foreach ($this->req['answers'] as $answer) {
			Openanswer::updateOrCreate($answer);
		}
		exit(json_encode(['msg' => 'Saved']));
	}

	public function actionDelete()
	{
		$q_id = $this->ajax['q_id'];

		$answers = Openanswer::findAllWhere('openquestion_id', $q_id);
		if ($answers ){
			foreach ($answers as $answer) {
				Openanswer::delete($answer['id']);
			}
		}
		$this->model::delete($q_id);
		exit(json_encode(['msg' => 'Вопрос и ответы удалены', 'q_id' => $q_id]));
	}


	public function actionSort()
	{
		$ids = $this->ajax['toChange'];
		if (!$ids) $this->exitWith('ok');
		$this->model::sort($ids);
		exit(json_encode(['msg' => 'Сортировка сохранена']));
	}

}
