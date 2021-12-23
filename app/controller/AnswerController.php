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
		$d = 0;
		$id = App::$app->answer->create($this->ajax)-1;
		exit(json_encode(['id'=>$id, 'msg'=>'ok']));
	}

	public function actionDelete()
	{
		if (App::$app->answer->delete($this->ajax['a_id'])) {
			exit(json_encode(['msg' => 'ok']));
		}

	}

	public function actionShow()
	{
		if ($this->ajax) {
			$a_id = App::$app->answer->autoincrement();
			$q_id = $this->ajax['q_id'];

			App::$app->answer->create([]);
		}
		$index = 1;
		$answer = include ROOT . '/app/view/Test/editBlockAnswer.php';
	}

}
