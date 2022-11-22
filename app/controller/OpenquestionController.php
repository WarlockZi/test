<?php

namespace app\controller;

use app\model\Openanswer;
use app\model\Openquestion;


class OpenquestionController Extends AppController
{
	private $model = Openquestion::class;

	public function __construct(array $route)
	{
		parent::__construct($route);

	}

	public function actionShow()
	{
	}

	public function actionUpdateOrCreate()
	{
		if ($this->ajax) {
			$qId = $this->model::updateOrCreate($this->ajax);
			if ($qId === false) {
				$this->exitWithError('Ошибка openquest');
			} elseif (is_int($qId)) {
				$this->exitJson([
					'id' => $qId,
					'popup' => 'Вопросы и ответы сохранены'
				]);
			} elseif ($qId === true) {
				$this->exitWithPopup('Вопросы и ответы сохранены');
			}
		}

	}

	public function actionChangeParent()
	{
		if ($ids = $this->ajax) {
			$id = $ids['id'];
			$testId = $ids['test_id'];
			$q = $this->model::where('id', '=', $id)
				->get();
			$q[0]['opentest_id'] = $testId;
			$this->model::update($q[0]);
			$this->exitJson([
				'msg' => 'ok',
			]);
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
		$q_id = $this->ajax['id'];

		$answers = Openanswer::findAllWhere('openquestion_id', $q_id);
		if ($answers) {
			foreach ($answers as $answer) {
				Openanswer::delete($answer['id']);
			}
		}
		$this->model::delete($q_id);
		$this->exitJson(['msg' => 'Вопрос и ответы удалены', 'q_id' => $q_id]);
	}


	public function actionSort()
	{
		$ids = $this->ajax['toChange'];
		if (!$ids) $this->exitWithPopup('ok');
		$this->model::sort($ids);
		$this->exitWithPopup('Сортировка сохранена');
	}

}
