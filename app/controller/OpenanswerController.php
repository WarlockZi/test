<?php

namespace app\controller;

use app\model\Openanswer;


class OpenanswerController Extends AppController
{
	private $model = Openanswer::class;
	private $table = 'openanswers';

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->autorize();
	}

	public function actionCreate()
	{
		$q_id = $this->ajax['q_id'];
		$answerCnt = $this->ajax['answerCnt'];

		$index = Openanswer::create(['openquestion_id' => $q_id]) - 1;
		$i = $answerCnt + 1;

		ob_start();
		include ROOT . '/app/view/Opentest/edit_BlockAnswer.php';
		$this->exitWith(ob_get_clean());

	}

	public function actionUpdateOrCreate()
	{
		try {
			if ($this->ajax) {
				$res = $this->model::updateOrCreate($this->ajax);
				if (is_int($res)) {
					$i = $this->ajax['sort'];

					ob_start();
					include ROOT . '/app/view/Opentest/edit_BlockAnswer.php';
					$html = ob_get_clean();
					exit(json_encode(['id' => $res, 'html' => $html]));
				}
				$this->exitWith('ok');
			}
		} catch (Exception $exception) {
			exit($exception->getMessage());
		};
	}


//	public function actionUpdate()
//	{
//		$this->model::updateOrCreate($this->req['question']);
//
//		foreach ($this->req['answers'] as $answer) {
//			Openanswer::updateOrCreate($answer);
//		}
//		exit(json_encode(['msg' => 'Saved']));
//	}

	public function actionDelete()
	{
		$id = $this->ajax['id'];
		if (Openanswer::delete($id)) {
			$this->exitWith('ok');
		}
	}

}
