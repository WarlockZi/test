<?php

namespace app\controller;

use app\model\Answer;

class AnswerController Extends AppController
{
	public $model = Answer::class;

	public function __construct(array $route)
	{
		parent::__construct($route);
	}

//	public function actionUpdateOrCreate()
//	{
//		if ($this->ajax)
//
//			$answer = Answer::updateOrCreate(['id'=>$this->ajax['id']],$this->ajax);
//			if ($answer->wasRecentlyCreated) {
//        $this->exitJson(['popup' => 'Создан', 'id' => $id]);
//			}else{
//				$this->exitWithError('Ответ не сохранен');
//			}
//
//	}

//	public function actionDelete()
//	{
//		$id =
//
//		if ($this->ajax['id']) {
//
//			if (Answer::find()delete($this->ajax['id'])) {
//				$this->exitWithPopup('Ответ удален');
//			}
//		} else {
//			$this->exitWithMsg('No id');
//		}
//	}

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
