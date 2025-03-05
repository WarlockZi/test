<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Answer;

class AnswerController Extends AdminscController
{
	protected string $model = Answer::class;

	public function __construct()
	{
		parent::__construct();
	}

//	public function actionShow()
//	{
//		if ($this->ajax) {
//			$a_id = Answer::autoincrement();
//			$q_id = $this->ajax['q_id'];
//
//			Answer::create([]);
//		}
//		$index = 1;
//		$answer = include ROOT . '/app/view/Test/edit_BlockAnswer.php';
//	}

}
