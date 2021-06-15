<?php

namespace app\controller;

use app\core\App;
use app\model\Answer;

class AnswerController Extends AppController
{

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->auth();
	}

	public function actionCreate()
	{
		App::$app->answer->create('answer', $_POST['answer']);
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

			App::$app->answer->show($a_id, $q_id);
		}
	}

}
