<?php

namespace app\controller;

use app\core\App;
use app\model\Answer;

class AnswerController Extends AppController
{

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->autorize();
	}

	public function actionCreate()
	{
		$id = Answer::create($this->ajax) - 1;
		exit(json_encode(['id' => $id, 'msg' => 'ok']));
	}

	public function actionDelete()
	{
		if ($this->ajax['id']) {
			if (Answer::delete($this->ajax['id'])) {
				$this->exitWithPopup('Ответ удален');
			}
		}else{
			$this->exitWithMsg('No id');
		}
	}

	public function actionShow()
	{
		if ($this->ajax) {
			$a_id = Answer::autoincrement();
			$q_id = $this->ajax['q_id'];

			Answer::create([]);
		}
		$index = 1;
		$answer = include ROOT . '/app/view/Test/edit_BlockAnswer.php';
	}

}
